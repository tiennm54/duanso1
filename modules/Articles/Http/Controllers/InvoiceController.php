<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Articles\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use App\Helpers\SeoPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Log;

/**
 * Description of InvoiceController
 *
 * @author minht
 */
class InvoiceController extends Controller {

    public function sendMailPaid($model_orders) {
        $subject_email = SUBJECT_CUSTOMER_PAID . $model_orders->order_no;
        Mail::send('admin::userOrders.email-send-paid', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
        });
    }

    public function view($id, $email) {
        SeoPage::seoPage($this);
        $model = UserOrders::find($id);
        if ($model != null) {
            if (trim($model->email) == trim($email)) {
                $model_order = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
                return view('articles::invoice.view', compact('model', 'model_order'));
            }
        }
    }

    public function paypalPay($token) {
        $model = null;
        $decode = base64_decode($token);
        $explode = explode("-", $decode);
        if (count($explode) == 4) {
            if ($explode[0] == PRIVATE_PAYPAL_KEY) {
                $time = $explode[3];
                $now = time();
                $number_date = ($now - $time) / 3600;
                if ($number_date <= 12) {
                    $order_id = $explode[1];
                    $model = UserOrders::find($order_id);
                }
            }
        }
        return view('articles::invoice.paypalPay', compact('model'));
    }

    public function callbackPaypalPay(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            //Log::info($data);
            if ($data["payment_status"] == "Completed") {
                $order_reponse = $data["item_name"];
                $explode = explode("-", $order_reponse);
                $order_id = $explode[1];
                //Log::info($order_id);
                $payment_gross = $data['payment_gross'] + 0;
                if ($order_id != null && $order_id != "") {
                    $model = UserOrders::find($order_id);
                    if ($model) {
                        if ($model->total_price == $payment_gross) {
                            $model->payment_status = "paid";
                            $model->save();
                            $this->sendMailPaid($model);
                            return redirect()->route('frontend.invoice.paySuccess');
                        } else {
                            $model->payment_status = "echeck";
                            $model->save();
                        }
                    }
                }
            }
        }
    }

    public function paySuccess() {
        return view('articles::invoice.paySuccess');
    }

}
