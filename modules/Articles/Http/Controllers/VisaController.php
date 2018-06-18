<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Articles\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\UserOrders;
use App\Models\VisaPaymentLog;
use App\Models\BonusPaymentHistory;
use App\Models\UserOrdersHistory;
use Log;
use DB;
use Illuminate\Support\Facades\Mail;

/**
 * Description of VisaController
 *
 * @author minht
 */
class VisaController extends Controller {

    public function checkoutSuccess() {
        return view('articles::checkoutVisa.checkout-success');
    }

    public function checkoutCallback(Request $request) {
        /*
          action = 'Product'
          buyer = Name of the customer
          comment = Any additional system comments
          orderid = An auto-generated 8-digit code OR a code supplied by the merchant
          pid = The Qwikpay product ID
          pname = The name of the product
          quantity = Total products purchased
          status = 'Transaction Success' OR 'Transaction Failed'
          total = Total amount received by the Merchant (USD)
          signature = this is a security implementation to allow users to verify that the IPN is from Qwikpay Servers (as a legitimate payment notification). */

        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            Log::info("DATA CALBACK CUA DON HANG: " . $data["orderid"]);
            Log::info($data);

            $action = (isset($data["action"])) ? $data["action"] : "";
            $buyer = (isset($data["buyer"])) ? $data["buyer"] : "";
            $comment = (isset($data["comment"])) ? $data["comment"] : "";
            $orderid = (isset($data["orderid"])) ? $data["orderid"] : 0;
            $pid = (isset($data["pid"])) ? $data["pid"] : "";
            $pname = (isset($data["pname"])) ? $data["pname"] : "";
            $quantity = (isset($data["quantity"])) ? $data["quantity"] : 0;
            $status = (isset($data["status"])) ? $data["status"] : "";
            $total = (isset($data["total"])) ? $data["total"] : 0;
            $signature = (isset($data["signature"])) ? $data["signature"] : "";

            $checkSignature = md5(VISA_CODE . $action . $buyer . $comment . $orderid . $pid . $pname . $quantity . $status . $total);
            //Log::info("Signature: " . $signature);
            //Log::info("CheckSignature: " . $checkSignature);
            if ($signature == $checkSignature) {
                Log::info("Signature OKIEEEE");
                $model_log = new VisaPaymentLog();
                $model_log->saveLog($data);
                $orderid_int = (int) $orderid;
                $model = UserOrders::find($orderid_int);
                if ($model) {
                    if ($status == "Transaction Success" && $model->total_price == $total) {
                        $this->paymentByBonusVisa($model);
                        $model->payment_status = "paid";
                        $model->save();
                        $model_orders_history = new UserOrdersHistory();
                        $model_orders_history->saveHistoryOrder($model);
                        $this->sendMailPaid($model);
                        $this->sendEmailNotifyAdmin($model);
                        DB::commit();
                        return redirect()->route('frontend.checkoutVisa.success');
                    } else {
                        Log::info("ERORR!!! TRANG THAI DON HANG TRA VE LOI: " . $status . " TOTAL PRICE LA: " . $total);
                    }
                } else {
                    Log::info("ERORR!!! KHONG TIM THAY ORDER CÓ ID LA: " . $orderid);
                }
                //Check Signature thi co the save log
                DB::commit();
            } else {
                Log::info("Signature ERRROR");
            }
        } else {
            Log::info("ERORR!!! ERROR KHONG NHAN DUOC REQUEST");
        }
        Log::info("ERORR!!!");
        return redirect()->route('frontend.checkoutVisa.failure');
    }

    public function getCallback() {
        return view('articles::checkoutVisa.checkout-failure');
    }

    public function checkoutFailure() {
        return view('articles::checkoutVisa.checkout-failure');
    }

//XÁC NHẬN THANH TOÁN CHO NGƯỜI DÙNG TRONG TRƯỜNG HỢP NGƯỜI DÙNG DÙNG PHƯƠNG THỨC THANH TOÁN BẰNG TIỀN BONUS
    public function paymentByBonusVisa($model_order) {
        if ($model_order->used_bonus > 0) {
            $count_order = BonusPaymentHistory::where("user_orders_id", "=", $model_order->id)->count();
            if ($count_order > 0) {
                BonusPaymentHistory::where("user_orders_id", "=", $model_order->id)->update(["status" => "completed"]);
            }
        }
    }

    public function sendMailPaid($model_orders) {
        $subject_email = SUBJECT_CUSTOMER_PAID . $model_orders->order_no;
        Mail::send('admin::userOrders.email-send-paid', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }

    public function sendEmailNotifyAdmin($model_orders) {
        $subject_email = "Customer PAY VISA for order: " . $model_orders->order_no;
        Mail::send('articles::checkoutVisa.email-notify-admin', ['model_orders' => $model_orders], function ($m) use ($subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to(EMAIL_RECEIVE_VISA, "Admin")->subject($subject_email);
        });
    }

}
