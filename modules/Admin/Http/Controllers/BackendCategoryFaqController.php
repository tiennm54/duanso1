<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\CategoryFaq;
use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Http\Requests\CategoryFaqRequest;
use Illuminate\Http\Request;

class BackendCategoryFaqController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

    public function index(){
        $model = CategoryFaq::orderBy('id', 'DESC')->get();
        return view('admin::categoryFaq.index', compact('model'));
    }

    public function getCreate()
    {
        return view('admin::categoryFaq.create');
    }

    public function postCreate(CategoryFaqRequest $request){
        if (isset($request)){
            $data = $request->all();
            $model = new CategoryFaq();
            $model->title = $data["title"];
            $model->url_title = str_slug($data["title"], '-');
            $model->description = $data["description"];
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
            return redirect()->route('admin.categoryFaq.getEdit', ["id" => $model->id]);
        }
    }


    public function getEdit($id){
        $model = CategoryFaq::find($id);
        if ($model){
            return view('admin::categoryFaq.create',compact('model'));
        }
    }


    public function postEdit(Request $request, $id){
        $data = $request->all();
        $model = CategoryFaq::find($id);

        if ($model){
            $model->title = $data["title"];
            $model->description = $data["description"];
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
            return redirect()->route('admin.categoryFaq.getEdit', ["id" => $model->id]);
        }
    }
}

?>