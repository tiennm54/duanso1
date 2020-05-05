<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\CouponsType;
use App\Models\Coupons;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class CouponsTypeManagementController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $model = CouponsType::orderBy("id", "DESC")->get();
        return view('admin::couponsType.index', compact('model'));
    }

    public function getCreate() {
        return view('admin::couponsType.create');
    }

    public function postCreate(Request $request) {
        if ($request) {
            $data = $request->all();
            $model = new CouponsType();
            $model->title = $data["title"];
            $model->description = $data["description"];
            $model->save();
            $request->session()->flash('alert-success', 'Success: Created Coupons Type Success!');
            return redirect()->route('admin.couponsType.index');
        }
    }

    public function getEdit($id) {
        $model = CouponsType::find($id);
        if ($model != null) {
            return view('admin::couponsType.create', compact('model'));
        }
    }

    public function postEdit($id, Request $request) {
        $model = CouponsType::find($id);
        if ($model != null) {
            $data = $request->all();
            $model->title = $data["title"];
            $model->description = $data["description"];
            $model->save();
            $request->session()->flash('alert-success', 'Success: Edited  Coupons Type Success!');
            return back();
        }
    }

    public function delete($id, Request $request) {
        $model = CouponsType::find($id);
        if ($model != null) {
            $check = Coupons::where("coupons_type_id", "=", $model->id)->count();
            if ($check == 0) {
                $model->delete();
                $request->session()->flash('alert-success', 'Success: Deleted  Coupons Type Success!');
                return back();
            }
        }
    }

}
