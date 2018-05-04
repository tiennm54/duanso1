<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\News;
use App\Models\Category;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Auth;

class BackendNewsController extends Controller
{

    public function __construct()
    {
        $this->middleware("role");
    }

    public function getCreate(){
        $model_cate = Category::get();
        return view('admin::news.create', compact('model_cate'));
    }

    public function postCreate(Request $request){

        if (isset($request)){
            $data = $request->all();
            $model = new News();
            $model->product_id = $data["product_id"];
            $model->title = $data["title"];
            $model->url_title = str_slug($data["title"], '-');
            $model->description = $data["description"];
            $model->category_id = $data["category_id"];

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
        $model_cate = Category::get();
        if ($model){
            return view('admin::news.create',compact('model','model_cate'));
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
                $model->category_id = $data["category_id"];
                $model->save();
                return redirect()->route('admin.news.getEdit', ["id" => $model->id]);
            }
        }
    }

    public function index(Request $request){
        $model_cate = Category::get();
        $model = new News();
        if(isset($request->filter_title) && $request->filter_title != ""){
            $model = $model->where("title","LIKE","%". $request->filter_title . "%");
        }
        if(isset($request->filter_category) && $request->filter_category != ""){
            $model = $model->where("category_id","=",$request->filter_category);
        }
        $model = $model->orderBy('id','DESC')->paginate(NUMBER_PAGE);
        return view('admin::news.index', compact('model','model_cate'));
    }
}