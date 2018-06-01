<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\CategoryFaq;
use App\Models\Faq;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;

class BackendFaqController extends Controller {

    public function __construct(){
        $this->middleware("editor");
    }

    public function index(Request $request){
        $data = $request->all();
        $model = Faq::orderBy('id', 'DESC');
        if (isset($data["category"]) && $data["category"] != 0) {
            $model = $model->where("category_faq_id","=",$data["category"]);
        }
        if(isset($data["filter_title"]) && $data["filter_title"] != ""){
            $model = $model->where("title","LIKE","%" . $data["filter_title"] . "%");
        }
        
        $model = $model->get();
        $model_cate = CategoryFaq::get();
        if($model && $model_cate) {
            return view('admin::faq.index', compact('model','model_cate'));
        }
    }

    public function getCreate()
    {
        $model_cate = CategoryFaq::get();
        if($model_cate){
            return view('admin::faq.create', compact('model_cate'));
        }
    }

    public function postCreate(Request $request){
        if (isset($request)){
            $data = $request->all();
            $model = new Faq();
            $model->title = $data["title"];
            $model->url_title = str_slug($data["title"], '-');
            $model->description = $data["description"];
            $model->category_faq_id = $data["category_faq_id"];

            if(isset($data["seo_description"])) {
                $model->seo_description = $data["seo_description"];
            }
            if(isset($data["seo_title"])) {
                $model->seo_title = $data["seo_title"];
            }
            if(isset($data["seo_keyword"])) {
                $model->seo_keyword = $data["seo_keyword"];
            }

            $model->save();
            return redirect()->route('admin.faq.getEdit', ["id" => $model->id]);
        }
    }


    public function getEdit($id){
        $model = Faq::find($id);
        $model_cate = CategoryFaq::get();
        if ($model && $model_cate){
            return view('admin::faq.create',compact('model','model_cate'));
        }
    }


    public function postEdit(Request $request, $id){
        $data = $request->all();
        $model = Faq::find($id);

        if ($model){
            $model->title = $data["title"];
            $model->url_title = str_slug($data["title"], '-');
            $model->description = $data["description"];
            $model->category_faq_id = $data["category_faq_id"];

            if(isset($data["seo_description"])) {
                $model->seo_description = $data["seo_description"];
            }
            if(isset($data["seo_title"])) {
                $model->seo_title = $data["seo_title"];
            }
            if(isset($data["seo_keyword"])) {
                $model->seo_keyword = $data["seo_keyword"];
            }
            $model->save();
            return redirect()->route('admin.faq.getEdit', ["id" => $model->id]);
        }
    }
    
    public function delete($id, Request $request){
        $model = Faq::find($id);
        if($model){
            $model->delete();
            $request->session()->flash('alert-success', ' Success: Delete success!');
        }else{
            $request->session()->flash('alert-warning', ' Warning: Delete error!');
        }
        return back();
    }
}

?>