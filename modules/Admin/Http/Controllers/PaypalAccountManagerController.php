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
use App\Models\PaypalSell;
use Carbon\Carbon;
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

        //CAP NHAT THOI GIAN KET THUC NHAN TIEN
        $model_activate = PaypalAccount::where("status_activate", "=", "Activate")->where("id", "!=", $model->id)->first();
        if ($model_activate) {
            $model_activate->end_date = Carbon::now();
            $model_activate->save();
        }

        PaypalAccount::where('id', "!=", $model->id)->update(['status_activate' => "No_Activate"]);
        $model_payment = PaymentType::where("code", "=", "PAYPAL")->first();
        if ($model_payment != null) {
            $model_payment->email = $model->email;
            $model_payment->save();
            //CAP NHAT THOI GIAN BAT DAU NHAN TIEN
            $model->start_date = Carbon::now();
            $model->end_date = Carbon::now();
            $model->save();
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
            $model->vps_ip = $data["vps_ip"];
            $model->money_activate = $data["money_activate"];
            $model->money_hold = $data["money_hold"];
            $model->status_activate = $data["status_activate"];
            $model->status = $data["status"];
            $model->description = $data["description"];
            $model->save();

            if ($model->status_activate == "Activate") {
                if ($model->status != "Limit") {
                    $this->updatePaypalPayment($model);
                } else {
                    $request->session()->flash('alert-warning', 'Warning: Tài khoản này đang hoạt động hoặc đã bị LIMIT!');
                    return back();
                }
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
            $model->vps_ip = $data["vps_ip"];
            $model->money_activate = $data["money_activate"];
            $model->money_hold = $data["money_hold"];
            $model->status_activate = $data["status_activate"];
            $model->status = $data["status"];
            $model->description = $data["description"];
            $model->save();
            if ($data["status_activate"] == "Activate") {
                if ($model->status != "Limit") {
                    $this->updatePaypalPayment($model);
                } else {
                    $request->session()->flash('alert-warning', 'Warning: Tài khoản này đang hoạt động hoặc đã bị LIMIT!');
                    return back();
                }
            }
            DB::commit();
            $request->session()->flash('alert-success', 'Success: Edit Paypal Account Completed!');
        } else {
            $request->session()->flash('alert-warning', 'Warning: Edit Paypal Account Error!');
        }
        return back();
    }

    public function index() {
        $model = PaypalAccount::orderByRaw("FIELD(status, \"Work\", \"Pending\", \"Limit\")")
                ->orderByRaw("FIELD(status_activate, \"Activate\", \"No_Activate\")")
                ->get();
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

    public function sellPaypal(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            $id = $data["paypal_account_id"];
            if ($id != "" && $id > 0) {
                $model_paypal = PaypalAccount::find($id);
                if ($model_paypal) {
                    $model = new PaypalSell();
                    $model->paypal_account_id = $model_paypal->id;
                    $model->paypal_account_email = $model_paypal->email;
                    $model->money = $data["money"];
                    $model->email_buyer = $data["email_buyer"];
                    $model->name_buyer = $data["name_buyer"];
                    $model->save();
                    $request->session()->flash('alert-success', 'Success: Thêm 1 giao dịch mới thành công!');
                    return redirect()->route('admin.sellPaypal.index');
                }
            }
        }

        $request->session()->flash('alert-warning', 'Warning: Thêm 1 giao dịch mới thất bại!');
        return back();
    }

    public function indexSellPaypal(Request $request, $id = null) {
        $model = new PaypalSell();
        if (isset($id)) {
            $model_paypal = PaypalAccount::find($id);
            if ($model_paypal) {
                $model = $model->where("paypal_account_id", $model_paypal->id)->orderBy("id", "DESC");
            } else {
                $request->session()->flash('alert-warning', 'Warning: Không tồn tại tài khoản paypal có id = ' . $id);
            }
        }
        $model = $model->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return view('admin::paypal.indexSellPaypal', compact('model', 'model_paypal'));
    }

}
