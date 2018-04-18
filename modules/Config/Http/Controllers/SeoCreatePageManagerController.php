<?php

namespace Modules\Config\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SeoCreatePage;
use App\Models\Seo;
use Illuminate\Http\Request;
use Modules\Config\Http\Requests\SeoPageRequest;

class SeoCreatePageManagerController extends Controller {
    
    public function __construct() {
        $this->middleware("role");
    }

    public function getCreate() {
        $model = SeoCreatePage::orderBy('id', 'desc')->get();
        return view('config::seoCreatePage.create', compact('model'));
    }

    public function postCreate(SeoPageRequest $request) {
        if (isset($request)) {
            $name = $request->name;
            $code = $request->code;
            $model = new SeoCreatePage();
            $model->name = $name;
            $model->code = $code;
            $model->save();
            $request->session()->flash('alert-success', 'Success: Tạo thành công');
            return back();
        }
        $request->session()->flash('alert-warning', 'Warning: Tạo thất bại');
        return back();
    }
    
    public function postEdit(SeoPageRequest $request){
        $data = $request->all();
        if(isset($data['id'])){
            $model = SeoCreatePage::find($data['id']);
            if($model){
                $model->name = $data['name'];
                $model->code = $data['code'];
                $model->save();
                $model_seo = Seo::where("page_id",$model->id)->first();
                if($model_seo){
                    $model_seo->page_code = $model->code;
                    $model_seo->save();
                }
                return 1;
            }
        }
        return 0;
    }

}
?>

