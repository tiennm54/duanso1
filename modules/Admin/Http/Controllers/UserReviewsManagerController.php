<?php

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Reviews;

class UserReviewsManagerController extends Controller {
    
    public function __construct(){
        $this->middleware("role");
    }

    public function index(Request $request) {
        $model = Reviews::orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return view('admin::userReviews.index', compact('model'));
    }

    public function delete($id, Request $request) {
        if (isset($request)) {
            $model = Reviews::find($id);
            if ($model != null) {
                $model->delete();
                $request->session()->flash('alert-success', ' Success: Delete success!');
            } else {
                $request->session()->flash('alert-warning', ' Warning: Delete error!');
            }
        }
        return back();
    }

}
