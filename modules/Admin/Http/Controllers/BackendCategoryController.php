<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\Articles;
use App\Models\Category;
use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Input;

class BackendCategoryController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

    public function index(){
        $model = Category::orderBy('id', 'DESC')->get();
        return view('admin::category.index', compact('model'));
    }

    public function getCreate()
    {
        return view('admin::category.create');
    }

    public function postCreate(CategoryRequest $request){
        //if (isset($request)) {
            $data = Input::all();
            $model = new Category();
            $model->name = $data["txt_name"];
            $model->description = $data["txt_description"];
            $model->path_url = str_slug($data["txt_name"], '-');

            if (isset($data["txt_seo_title"])) {
                $model->seo_title = $data["txt_seo_title"];
            }

            if (isset($data["txt_seo_description"])) {
                $model->seo_description = $data["txt_seo_description"];
            }

            $model->save();
            return redirect()->route('category.index');
       // }
    }


    public function getEdit($id){

        $model = Category::find($id);
        if ($model) {
            return view('admin::category.edit', compact('model','id'));
        }else{
            return view('errors.503');
        }
    }


    public function postEdit(Request $request, $id){
        $data = $request->all();
        $model = Category::find($id);

        if ($model){
            if (isset($data["txt_name"]) && isset($data["txt_description"])){
                $model->name = $data["txt_name"];
                $model->description = $data["txt_description"];
            }

            if(isset($data["txt_seo_title"])){
                $model->seo_title = $data["txt_seo_title"];
            }

            if(isset($data["txt_seo_description"])){
                $model->seo_description = $data["txt_seo_title"];
            }

            $model->save();

            return redirect()->route('category.index');
        }
    }

    public function delete($id){
        $model = Category::find($id);
        if ($model != null){
            $count_articles = Articles::where("category_id","=",$id)->count();
            if ($count_articles == 0){
                $model->delete();
                return redirect()->route('category.index');
            }else{
                return view('errors.503');
            }

        }else{
            return view('errors.503');
        }
    }

}

?>