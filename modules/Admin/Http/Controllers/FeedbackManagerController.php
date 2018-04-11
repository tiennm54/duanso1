<?php
namespace Modules\Admin\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedBack;

class FeedbackManagerController extends Controller {
    public function __construct(){
        $this->middleware("role");
    }
    
    public function index(){
        $model = FeedBack::orderBy('id','desc')->paginate(5);
        return view('admin::feedback.index', compact('model'));
    }
    
    public function view($id){
        $model = FeedBack::find($id);
        if($model != null){
            return view('admin::feedback.view', compact('model'));
        }
        return back();
    }
    
    public function saveFinish($id, Request $request){
        $model = FeedBack::find($id);
        if($model != null){
            $model->status_fix = "OK";
            $model->save();
            $request->session()->flash('alert-success', 'Success: Save finish completed!');
        }else{
            $request->session()->flash('alert-warning', 'Warning: Save finish error!');
        }
        return back();
    }
    
}