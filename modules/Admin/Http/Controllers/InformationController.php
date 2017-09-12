<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\Information;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;
use DB;
use Input;
use Excel;

class InformationController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

    public function getCreate(){
        return view('admin::information.create');
    }

    public function postCreate(Request $request){
        if(isset($request)){
            $data = $request->all();
            $data["url_title"] = str_slug($data["title"], '-');
            $id = Information::insertGetId($data);
            return redirect()->route('admin.information.getEdit', ["id" => $id]);
        }
    }

    public function index(){

        $model = Information::orderBy("id","DESC")->get();
        return view('admin::information.index',compact('model'));

    }

    public function getEdit($id){

        $model = Information::find($id);
        if ($model){
            return view('admin::information.create',compact('model'));
        }

    }

    public function postEdit($id, Request $request){
        if (isset($request)){
            $model = Information::find($id);
            if ($model) {
                $data = $request->all();
                $model->title = $data["title"];
                $model->description = $data["description"];
                $model->meta_tag_title = $data["meta_tag_title"];
                $model->meta_tag_description = $data["meta_tag_description"];
                $model->meta_tag_keyword = $data["meta_tag_keyword"];
                $model->save();
                return redirect()->route('admin.information.getEdit', ["id" => $model->id]);
            }

        }
    }

}