<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Http\Requests\PaypalAccountRequest;
use Illuminate\Http\Request;
use App\Models\PaypalAccount;
use App\Models\PaymentType;
use App\Models\PaypalSell;
use App\Models\PaypalReceive;
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
            $model_payment->paypal_account_id = $model->id;
            if ($model->website != "" && $model->status_website == 1) {
                $model_payment->status_website = 1;
                $model_payment->website = $model->website;
            } else {
                $model_payment->status_website = 0;
                $model_payment->website = "";
            }
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

    public function postCreate(PaypalAccountRequest $request) {
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
            $model->website = $data["website"];
            $model->status_website = $data["status_website"];
            $model->phone = $data["phone"];
            $model->user_verify = $data["user_verify"];

            if (isset($request->document)) {
                if ($request->hasFile('document')) {
                    $file = $request->file('document');
                    $input['file_name'] = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('/documents');
                    $file->move($destinationPath, $input['file_name']);
                    $model->document = $input['file_name'];
                }
            }

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

    public function postEdit($id, PaypalAccountRequest $request) {
        $model = PaypalAccount::find($id);
        if ($model) {
            DB::beginTransaction();
            $data = $request->all();

            $old_file = $model->document;

            $model->email = $data["email"];
            $model->password = $data["password"];
            $model->full_name = $data["full_name"];
            $model->vps_ip = $data["vps_ip"];
            $model->money_activate = $data["money_activate"];
            $model->money_hold = $data["money_hold"];
            $model->status_activate = $data["status_activate"];
            $model->status = $data["status"];
            $model->description = $data["description"];
            $model->website = $data["website"];
            $model->status_website = $data["status_website"];
            $model->phone = $data["phone"];
            $model->user_verify = $data["user_verify"];

            if (isset($request->document)) {
                if ($request->hasFile('document')) {
                    $file = $request->file('document');
                    $input['file_name'] = time() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('/documents');
                    $file->move($destinationPath, $input['file_name']);
                    $model->document = $input['file_name'];
                    if ($old_file && file_exists('documents/' . $old_file)) {
                        unlink('documents/' . $old_file);
                    }
                }
            }

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

    public function index(Request $request) {

        $model = new PaypalAccount();
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["email"]) && $data["email"] != "") {
                $model = $model->where("email", "LIKE", "%" . trim($data["email"]) . "%");
            }
            if (isset($data["vps"]) && $data["vps"] != "") {
                $model = $model->where("vps_ip", "LIKE", "%" . trim($data["vps"]) . "%");
            }

            if (isset($data["phone"]) && $data["phone"] != "") {
                $model = $model->where("phone", "LIKE", "%" . trim($data["phone"]) . "%");
            }

            if (isset($data["status_limit"]) && $data["status_limit"] != "") {
                $model = $model->where("status", $data["status_limit"]);
            }
            if (isset($data["status_activate"]) && $data["status_activate"] != "") {
                $model = $model->where("status_activate", $data["status_activate"]);
            }
        }

        $model = $model->orderByRaw("FIELD(status_activate, \"Activate\", \"No_Activate\")")
                ->orderByRaw("FIELD(status, \"Work\", \"Pending\", \"Limit\")")
                ->paginate(NUMBER_PAGE);
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
                    if ($model_paypal->money_activate >= $data["money"]) {
                        $model = new PaypalSell();
                        $model->paypal_account_id = $model_paypal->id;
                        $model->paypal_account_email = $model_paypal->email;
                        $model->money = $data["money"];
                        $model->email_buyer = $data["email_buyer"];
                        $model->name_buyer = $data["name_buyer"];
                        $model->save();

                        $model_paypal->money_activate = $model_paypal->money_activate - $data["money"];
                        $model_paypal->save();

                        $request->session()->flash('alert-success', 'Success: Thực hiện giao dịch thành công!');
                        return redirect()->route('admin.sellPaypal.index');
                    } else {
                        $request->session()->flash('alert-warning', 'Warning: Số tiên trong tài khoản không đủ để thực hiện giao dịch!');
                        return back();
                    }
                }
            }
            $request->session()->flash('alert-warning', 'Warning: Đã xảy ra lỗi khi thực hiện giao dịch!');
            return back();
        }

        $request->session()->flash('alert-warning', 'Warning: Thêm 1 giao dịch mới thất bại!');
        return back();
    }

    public function indexSellPaypal(Request $request, $id = null) {
        $model = new PaypalSell();
        if (isset($id)) {
            $model_paypal = PaypalAccount::find($id);
            if ($model_paypal) {
                $model = $model->where("paypal_account_id", $model_paypal->id);
            } else {
                $request->session()->flash('alert-warning', 'Warning: Không tồn tại tài khoản paypal có id = ' . $id);
            }
        }
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["email_buyer"]) && $data["email_buyer"] != "") {
                $model = $model->where("email_buyer", "LIKE", "%" . trim($data["email_buyer"]) . "%");
            }
            if (isset($data["paypal_account_email"]) && $data["paypal_account_email"] != "") {
                $model = $model->where("paypal_account_email", "LIKE", "%" . trim($data["paypal_account_email"]) . "%");
            }
        }
        $model = $model->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return view('admin::paypal.indexSellPaypal', compact('model', 'model_paypal'));
    }

    public function editPaypalSell(Request $request) {
        if (isset($request)) {
            $data = $request->all();

            if (isset($data["paypal_sell_id"]) && $data["paypal_sell_id"] != "") {
                $model = PaypalSell::find($data["paypal_sell_id"]);
                if ($model) {
                    $model->money = $data["money"];
                    $model->status = $data["status"];
                    $model->save();
                    $request->session()->flash('alert-success', 'Success: EDIT COMPLETED');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: EDIT ERROR!');
        return back();
    }

    public function indexPaypalReceive(Request $request, $id = null) {
        $model = new PaypalReceive();
        $data = $request->all();
        if (isset($id)) {
            $model_paypal = PaypalAccount::find($id);
            if ($model_paypal) {
                $model = $model->where("paypal_account_id", $model_paypal->id);
            }
        }

        if (isset($data["paypal_account_email"]) && $data["paypal_account_email"] != "") {
            $model = $model->where("paypal_account_email", "LIKE", "%" . trim($data["paypal_account_email"]) . "%");
        }
        if (isset($data["email_paid"]) && $data["email_paid"] != "") {
            $model = $model->where("email_paid", "LIKE", "%" . trim($data["email_paid"]) . "%");
        }
        if (isset($data["order_no"]) && $data["order_no"] != "") {
            $model = $model->where("order_no", "LIKE", "%" . trim($data["order_no"]) . "%");
        }

        if (isset($data["status_receive"]) && $data["status_receive"] != "") {
            $model = $model->where("status", $data["status_receive"]);
        }

        $model = $model->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return view('admin::paypal.indexPaypalReceive', compact('model', 'model_paypal'));
    }

    public function editPaypalReceive(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["paypal_receive_id"]) && $data["paypal_receive_id"] != "") {
                $id = $data["paypal_receive_id"];
                $status = $data["status"];
                $model = PaypalReceive::find($id);
                $model_paypal = PaypalAccount::find($model->paypal_account_id);
                if ($model && $model_paypal) {
                    switch ($status) {
                        case "completed" :
                            if ($model->status == "pending") {
                                //Trừ tiền trong tài khoản hold
                                $model_paypal->money_hold = $model_paypal->money_hold - $model->total_receive;
                                //Cộng tiền vào tài khoản activate
                                $model_paypal->money_activate = $model_paypal->money_activate + $model->total_receive;
                            } else {
                                $request->session()->flash('alert-warning', 'Success: Không thể chuyển đổi trạng thái cho đơn hàng này!');
                                return back();
                            }
                            break;
                        case "pending" :
                            if ($model->status == "completed") {
                                $model_paypal->money_hold = $model_paypal->money_hold + $model->total_receive;
                                $model_paypal->money_activate = $model_paypal->money_activate - $model->total_receive;
                            } else {
                                $request->session()->flash('alert-warning', 'Success: Không thể chuyển đổi trạng thái cho đơn hàng này!');
                                return back();
                            }
                            break;
                        case "refund" :
                            if ($model->status == "completed") {
                                $model_paypal->money_activate = $model_paypal->money_activate - $model->total_receive;
                            } else {
                                $model_paypal->money_hold = $model_paypal->money_hold - $model->total_receive;
                            }
                            break;
                    }
                    $model->status = $status;
                    $model_paypal->save();
                    $model->save();
                    $request->session()->flash('alert-success', 'Success: EDIT COMPLETED');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', 'Warning: EDIT ERROR');
        return back();
    }

}
