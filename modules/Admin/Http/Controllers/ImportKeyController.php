<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\ArticlesType;
use App\Models\KeyStock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
use Log;
use Input;
use Excel;

class ImportKeyController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

    public function getImport($id = 0){
        $model = ArticlesType::find($id);
        return view('admin::import.import-key', compact('model'));
    }

    public function postImport(Request $request){

        $data = $request->all();
        if (isset($data["product_id"])) {
            $product_id = $data["product_id"];
            $model = ArticlesType::find($product_id);

            if ($model) {


                if (Input::hasFile('import_file')) {
                    $path = Input::file('import_file')->getRealPath();
                    $data = Excel::load($path, function ($reader) {
                    })->get();
                    
                    if (!empty($data) && $data->count()) {
                        $flag = true;
                        $error = array();
                        $insert = array();
                        
                        $count = 0;
                        foreach ($data as $key => $value) {
                            //Log::info($value);
                            //Hàm cũ
                            //$check = KeyStock::where("premium_key", "=", trim($value->key))->where("articles_type_id","=",$product_id)->count();
                            //Hàm mới
                            $check = KeyStock::where("premium_key", "=", trim($value->key))->count();
                            
                            if ($check == 0) {
                                
                                $tmp = array(
                                    "articles_type_id" => $product_id,
                                    "articles_type_title" => $model->title,
                                    "status_paid" => 0,
                                    "status" => "Pending",
                                    "premium_key" => $value->key,
                                    "created_at" => Carbon::now(),
                                    "updated_at" => Carbon::now()
                                );

                                array_push($insert, $tmp);
                                $count++;

                            } else {

                                $tmp_error = array(
                                    "key" => $value->key
                                );

                                array_push($error, $tmp_error);

                            }
                        }

                        if ($flag == true) {
                            KeyStock::insert($insert);
                            $request->session()->flash('alert-success', 'Success: Import thành công: ' . $count . ' key.');
                            return redirect()->route('admin.keyStock.getCreate', ['id' => $model->id]);
                        } else {
                            return $error;
                        }
                    }
                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Bị lỗi rồi, Minh Tiến hãy cố gắng và vui lòng thực hiện lại!');
        return back();
    }


}