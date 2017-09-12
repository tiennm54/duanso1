<?php namespace Modules\Config\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller  {

    public function __construct(){
        $this->middleware("role");
    }

    public function index(){
        $model = Seo::get();
        return view('config::seo.index', compact('model'));
    }

    public function getCreate(){
        return view('config::seo.create');
    }

    public function postCreate(Request $request){

        if (isset($request)) {
            $data = $request->all();
            $model = new Seo();
            $model->type = $data["type"];
            $model->seo_title = $data["seo_title"];
            $model->seo_description = $data["seo_description"];
            $model->seo_keyword = $data["seo_keyword"];
            $model->save();
            return redirect()->route('config.seo.getEdit', ["id" => $model->id]);
        }

        return back();

    }


    public function getEdit($id){
        $model = Seo::find($id);
        if ($model){
            return view('config::seo.create', compact('model'));
        }
    }

    public function postEdit($id, Request $request){
        $model = Seo::find($id);
        if ($model){
            $data = $request->all();
            $model->type = $data["type"];
            $model->seo_title = $data["seo_title"];
            $model->seo_description = $data["seo_description"];
            $model->seo_keyword = $data["seo_keyword"];
            $model->save();
            return redirect()->route('config.seo.getEdit', ["id" => $model->id]);
        }
    }


    public function getDelete($id){
        $model = Seo::find($id);
        if ($model){
            $model->delete();
        }
        return back();
    }




}