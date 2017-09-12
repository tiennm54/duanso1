<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\ArticlesType;
use App\Models\ArticlesTypeKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
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
                        foreach ($data as $key => $value) {
                            $check = ArticlesTypeKey::where("key", "=", trim($value->key))->where("articles_type_id","=",$product_id)->count();
                            if ($check == 0) {
                                $tmp = array(
                                    "articles_type_id" => $product_id,
                                    "key" => $value->key,
                                    "created_at" => Carbon::now(),
                                    "updated_at" => Carbon::now()
                                );

                                array_push($insert, $tmp);

                            } else {

                                $tmp_error = array(
                                    "key" => $value->key
                                );

                                array_push($error, $tmp_error);

                            }
                        }

                        if ($flag == true) {

                            ArticlesTypeKey::insert($insert);
                            $request->session()->flash('alert-success', 'Success: Cập nhật key thành công, chúc Minh Tiến một ngày gặt hái được nhiều thành công!');
                            return redirect()->route('import.getImport');

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