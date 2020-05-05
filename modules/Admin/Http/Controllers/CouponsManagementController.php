<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\CouponsType;
use App\Models\Coupons;
use Illuminate\Http\Request;
use Pingpong\Modules\Routing\Controller;

class CouponsManagementController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $model = Coupons::orderBy("id", "DESC")->get();
        return view('admin::coupons.index', compact('model'));
    }

    public function getCreate() {
        $model_type = CouponsType::orderBy("id", "DESC")->get();
        if ($model_type != null) {
            return view('admin::coupons.create', compact('model_type'));
        }
    }

    public function postCreate(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            $model = new Coupons();
            $model->coupon_code = $data["coupon_code"];
            $model->description = $data["description"];
            $model->expiry_date = $data["expiry_date"];
            $model->coupons_type_id = $data["coupons_type_id"];
            $model->save();
            $request->session()->flash('alert-success', 'Success: Created Coupons Success!');
            return redirect()->route('admin.coupons.index');
        }
    }

    public function getEdit($id) {
        $model_type = CouponsType::orderBy("id", "DESC")->get();
        $model = Coupons::find($id);
        if ($model != null) {
            if ($model_type != null) {
                return view('admin::coupons.create', compact('model_type', 'model'));
            }
        }
    }

    public function postEdit($id, Request $request) {
        if (isset($request)) {
            $model = Coupons::find($id);
            if ($model != null) {
                $data = $request->all();
                $model->coupon_code = $data["coupon_code"];
                $model->description = $data["description"];
                $model->expiry_date = $data["expiry_date"];
                $model->coupons_type_id = $data["coupons_type_id"];
                $model->save();
                $request->session()->flash('alert-success', 'Success: Edited  Coupons  Success!');
                return back();
            }
        }
    }

    public function delete($id, Request $request) {
        $model = Coupons::find($id);
        if ($model != null) {
            $model->delete();
            $request->session()->flash('alert-success', 'Success: Deleted  Coupons  Success!');
            return back();
        }
    }

}
