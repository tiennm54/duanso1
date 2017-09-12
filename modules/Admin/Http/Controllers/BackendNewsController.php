<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\Articles;
use App\Models\News;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Input;
use Auth;

class BackendNewsController extends Controller
{

    public function __construct()
    {
        $this->middleware("role");
    }

    public function getCreate(){
        return view('admin::news.create');
    }

    public function postCreate(Request $request){

        if (isset($request)){
            $data = $request->all();
            $model = new News();
            $model->product_id = $data["product_id"];
            $model->title = $data["title"];
            $model->url_title = str_slug($data["title"], '-');
            $model->description = $data["description"];

            $model->seo_description = $data["seo_description"];
            $model->seo_title = $data["seo_title"];
            $model->seo_keyword = $data["seo_keyword"];
            $model->created_by = Auth::user()->id;

            $model->save();
            return redirect()->route('admin.news.getEdit', ["id" => $model->id]);
        }
    }

    public function getEdit($id){
        $model = News::find($id);
        if ($model){
            return view('admin::news.create',compact('model'));
        }
    }

    public function postEdit(Request $request, $id){
        if(isset($request)){
            $data = $request->all();
            $model = News::find($id);
            if ($model) {
                $model->product_id = $data["product_id"];
                $model->title = $data["title"];
                $model->description = $data["description"];
                $model->seo_description = $data["seo_description"];
                $model->seo_title = $data["seo_title"];
                $model->seo_keyword = $data["seo_keyword"];
                $model->updated_by = Auth::user()->id;
                $model->save();
                return redirect()->route('admin.news.getEdit', ["id" => $model->id]);
            }
        }
    }

    public function index(){
        $model = News::orderBy("id","DESC")->get();
        return view('admin::news.index', compact('model'));
    }
}