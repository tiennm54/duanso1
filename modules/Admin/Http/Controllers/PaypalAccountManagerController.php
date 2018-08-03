<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\PaypalAccount;
use App\Models\PaymentType;
use DB;
use Log;

/**
 * Description of PaypalAccountManagerController
 *
 * @author minht
 */
class PaypalAccountManagerController extends Controller {

    //put your code here
    public function __construct() {
        $this->middleware("role");
    }

    public function updatePaypalPayment($model) {
        PaypalAccount::where('id', "!=", $model->id)->update(['status_activate' => "No_Activate"]);
        $model_payment = PaymentType::where("code", "=", "PAYPAL")->first();
        if ($model_payment != null) {
            $model_payment->email = $model->email;
            $model_payment->save();
        }
        return $model_payment;
    }

    public function getCreate() {
        return view('admin::paypal.create');
    }

    public function postCreate(Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            $model = new PaypalAccount();
            $model->email = $data["email"];
            $model->password = $data["password"];
            $model->full_name = $data["full_name"];
            $model->money_activate = $data["money_activate"];
            $model->money_hold = $data["money_hold"];
            $model->status_activate = $data["status_activate"];
            $model->status = $data["status"];
            $model->description = $data["description"];
            $model->save();

            if ($model->status_activate == "Activate" && $model->status != "Limit") {
                $this->updatePaypalPayment($model);
            } else {
                $request->session()->flash('alert-warning', 'Warning: Tài khoản này đã bị LIMIT!');
                return back();
            }

            DB::commit();
            $request->session()->flash('alert-success', 'Success: Create Paypal Account Completed!');
            return redirect()->route('admin.paypal.getEdit', ["id" => $model->id]);
        }
        return view('errors.503');
    }

    public function getEdit($id) {
        $model = PaypalAccount::find($id);
        if ($model) {
            return view('admin::paypal.create', compact('model'));
        }
    }

    public function postEdit($id, Request $request) {
        $model = PaypalAccount::find($id);
        if ($model) {
            DB::beginTransaction();
            $data = $request->all();
            $model->email = $data["email"];
            $model->password = $data["password"];
            $model->full_name = $data["full_name"];
            $model->money_activate = $data["money_activate"];
            $model->money_hold = $data["money_hold"];
            $model->status_activate = $data["status_activate"];
            $model->status = $data["status"];
            $model->description = $data["description"];
            $model->save();
            if ($data["status_activate"] == "Activate" && $model->status != "Limit") {
                $this->updatePaypalPayment($model);
            } else {
                $request->session()->flash('alert-warning', 'Warning: Tài khoản này đang hoạt động hoặc đã bị LIMIT!');
                return back();
            }
            DB::commit();
            $request->session()->flash('alert-success', 'Success: Edit Paypal Account Completed!');
        } else {
            $request->session()->flash('alert-warning', 'Warning: Edit Paypal Account Error!');
        }
        return back();
    }

    public function index() {
        $model = PaypalAccount::orderBy("id", "DESC")->get();
        return view('admin::paypal.index', compact('model'));
    }

    public function changeStatusActivate($id, Request $request) {
        $model = PaypalAccount::find($id);
        if ($model != null) {
            DB::beginTransaction();
            if ($model->status_activate == "No_Activate" && $model->status != "Limit") {
                $this->updatePaypalPayment($model);
                $model->status_activate = "Activate";
                $model->save();
                DB::commit();
                $request->session()->flash('alert-success', 'Success: Tài khoản này đã được kích hoạt thành công!');
            } else {
                $request->session()->flash('alert-warning', 'Warning: Tài khoản này đang hoạt động hoặc đã bị LIMIT!');
            }
        } else {
            $request->session()->flash('alert-warning', 'Warning: Không thể thay đổi trạng thái tài khoản này!');
        }
        return back();
    }

    public function delete($id, Request $request) {
        
        $model = PaypalAccount::find($id);
        if ($model != null) {
            if ($model->status_activate == "No_Activate") {
                $model_payment = PaymentType::where("email", "=", $model->email)->where("code", "=", "PAYPAL")->first();
                if ($model_payment == null) {
                    $model->delete();
                    $request->session()->flash('alert-success', 'Success: Xóa tài khoản thành công!');
                    return back();
                }
            }
        }

        $request->session()->flash('alert-warning', 'Warning: Tài khoản này đang được sử dụng!');
        return back();
    }

}
