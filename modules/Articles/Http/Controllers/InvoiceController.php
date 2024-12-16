<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Articles\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Models\UserOrders;
use App\Models\User;
use App\Models\UserOrdersDetail;
use App\Models\ArticlesTypeKey;
use App\Models\UserOrdersHistory;
use App\Models\PaypalReceive;
use App\Models\KeyStock;
use App\Helpers\SeoPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Log;
use DB;

/**
 * Description of InvoiceController
 *
 * @author minht
 */
class InvoiceController extends Controller {

    public function sendMailPaid($model_orders) {
        try {
            $subject_email = SUBJECT_CUSTOMER_PAID . $model_orders->id;
            Mail::send('admin::userOrders.email-send-paid', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
        }
    }

    //Gửi mail sản phẩm tới khách hàng
    public function sendProductEmail($model_orders, $model_key) {
        try {
            $subject_email = SUBJECT_SEND_PRODUCT . $model_orders->id;
            if ($model_orders->payment_status == "completed") {
                $subject_email = SUBJECT_RESEND_PRODUCT . $model_orders->id;
            }
            Mail::send('admin::userOrders.email-sent-product', ['model_orders' => $model_orders, 'model_key' => $model_key], function ($m) use ($model_orders, $subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
            $model_orders->saveEmailDie(1);
        }
    }

    public function view($id, $email) {
        SeoPage::seoPage($this);
        $model = UserOrders::find($id);
        if ($model != null) {
            if (trim($model->email) == trim($email)) {
                $model_order = UserOrdersDetail::where("user_orders_id", "=", $model->id)->get();
                $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model->id)->get();
                return view('articles::invoice.view', compact('model', 'model_order', 'model_key'));
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

    public function visaStripePay($token) {
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
        return view('articles::invoice.visaStripePay', compact('model'));
    }

    public function callbackPaypalPay(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            //Log::info($data);
            if (isset($data["payer_email"]) && $data["payer_email"] != "") {
                $payer_email = $data['payer_email'];
                $model_user = new User();
                $check_scam = $model_user->checkUserScam($payer_email);

                if (isset($data["payment_status"]) && $data["payment_status"] == "Completed") {
                    $order_reponse = "";
                    if(isset($data["item_name"])){
                        $order_reponse = $data["item_name"];
                    }
                    $explode = explode("-", $order_reponse);
                    $order_id = $explode[1];
                    //Log::info($order_id);
                    $payment_gross = 0;
                    if (isset($data["payment_gross"]) && $data["payment_gross"] != 0) {
                        $payment_gross = $data['payment_gross'] + 0;
                    }

                    if ($order_id != null && $order_id != "") {
                        $model = UserOrders::find($order_id);
                        if ($model) {
                            DB::beginTransaction();
                            if ($model->total_price == $payment_gross && $check_scam == false) {

                                if ($model->payment_status == "completed") {
                                    DB::commit();
                                    return redirect()->route('frontend.invoice.paySuccess');
                                }

                                //Thêm mới
                                $model_orders_history = new UserOrdersHistory();
                                $obj_paypal_history = new PaypalReceive();

                                $check_send_key = $this->getKeyFromStock($model);
                                //Log::info("===========Check key================");
                                //Log::info($check_send_key);
                                if ($check_send_key == 1) {//Đủ key để send đi
                                    $model_key = $this->getPremiumKeySend($model);
                                    if ($model_key) {

                                        foreach ($model_key as $item) {
                                            $item->status = "sent";
                                            $item->save();
                                        }

                                        $model->payment_status = "completed";
                                        $model->payment_date = Carbon::now();
                                        $model->save();

                                        $model_paypal_account = $model->paypalAccount;
                                        if ($model_paypal_account != null) {
                                            $model_paypal_account->start_date = Carbon::now();
                                            $model_paypal_account->end_date = Carbon::now();
                                            $model_paypal_account->save();
                                        }


                                        $model_orders_history->saveHistoryOrder($model);
                                        $obj_paypal_history->saveHistoryReceive($model, "completed");

                                        $this->sendProductEmail($model, $model_key);
                                        DB::commit();
                                        //return redirect()->route('frontend.invoice.paySuccess');
                                        return redirect()->route('frontend.invoice.view', ['id' => $model->id, 'email' => $model->email]);
                                    }
                                    //End thêm mới
                                } else {

                                    $model->payment_status = "paid";
                                    $model->save();
                                    $model_orders_history->saveHistoryOrder($model);
                                    $this->sendMailPaid($model);
                                    DB::commit();
                                    return redirect()->route('frontend.invoice.paySuccess');
                                }
                            } else {
                                $model->payment_status = "echeck";
                                $model->save();
                                $model_orders_history = new UserOrdersHistory();
                                $model_orders_history->saveHistoryOrder($model);
                                $model_user->addUserScam($model->email);
                                DB::commit();
                                return redirect()->route('frontend.invoice.paySuccess');
                            }
                        }
                    }
                }
            }
        }
    }

    ////CACH THANH TOAN PAYPAL MOI////////////////////////////////
    public function callbackPaypalPayNew($id, Request $request) {
        if (isset($request)) {
            $data = $request->all();
            //Log::info("callbackPaypalPayNew");
            //Log::info($data);
            if (isset($data["payer_email"]) && $data["payer_email"] != "") {
                $payer_email = $data['payer_email'];
                $model_user = new User();
                $check_scam = $model_user->checkUserScam($payer_email);
                
                $checkSignature = "";
                if (isset($data['receiver_id']) && isset($data['payment_gross']) && isset($data['payer_id'])) {
                    $checkSignature = md5(PAYPAL_PRIVATE_KEY . $data['receiver_id'] . $data['payment_gross'] . $id . $data['payer_id']);
                }
                //Log::info($checkSignature);
                //Log::info($data['bpk_private_key']);
                if (isset($data['bpk_private_key']) && $checkSignature == $data['bpk_private_key']) {
                    if (isset($data["payment_status"]) && $data["payment_status"] == "Completed") {
                        $order_id = $id;
                        //Log::info($order_id);
                        $payment_gross = 0;
                        if (isset($data["payment_gross"]) && $data["payment_gross"] != 0) {
                            $payment_gross = $data['payment_gross'] + 0;
                        }

                        if ($order_id != null && $order_id != "") {
                            $model = UserOrders::find($order_id);
                            //Log::info($model);
                            if ($model) {
                                DB::beginTransaction();
                                if ($model->total_price == $payment_gross && $check_scam == false) {

                                    if ($model->payment_status == "completed") {
                                        DB::commit();
                                        return redirect()->route('frontend.invoice.paySuccess');
                                    }

                                    $keyStock = new KeyStock();
                                    $model_key = $keyStock->sendAndChangeStatusKey($model);
                                    if ($model_key != null) {
                                        $model_paypal_account = $model->paypalAccount;
                                        if ($model_paypal_account != null) {
                                            $model_paypal_account->start_date = Carbon::now();
                                            $model_paypal_account->end_date = Carbon::now();
                                            $model_paypal_account->save();
                                        }
                                        $this->sendProductEmail($model, $model_key);
                                        DB::commit();
                                        return redirect()->route('frontend.invoice.view', ['id' => $model->id, 'email' => $model->email]);
                                    } else {
                                        $this->sendMailPaid($model);
                                        DB::commit();
                                        return redirect()->route('frontend.invoice.paySuccess');
                                    }
                                } else {
                                    $model->payment_status = "echeck";
                                    $model->save();
                                    $model_user->addUserScam($model->email);
                                    DB::commit();
                                    return redirect()->route('frontend.invoice.paySuccess');
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getKeyFromStock($model_orders) {
        $check = 1;
        $model_articles_key = ArticlesTypeKey::where("user_orders_id", "=", $model_orders->id)->get();
        if ($model_articles_key != null) {
            foreach ($model_articles_key as $key => $item) {
                $model_stock = KeyStock::where("articles_type_id", "=", $item->articles_type_id)->where("status", "=", "Pending")->orderBy("id", "DESC")->first();
                if ($model_stock != null) {
                    //Log::info("===========getKeyFromStock===============");
                    //Save trạng thái key trước khi send
                    $item->key = $model_stock->premium_key;
                    $item->status = "active";
                    //$item->date_sent = Carbon::now();
                    $item->user_id = $model_orders->users_id;
                    $item->user_email = $model_orders->email;
                    $item->save();

                    //Save stock
                    $model_stock->status = "Activated"; // trạng thái của stock
                    $model_stock->user_orders_id = $model_orders->id;
                    $model_stock->invoice = $model_orders->order_no;

                    $model_stock->user_activated_id = $model_orders->users_id;
                    $model_stock->user_activated_email = $model_orders->email;
                    $model_stock->save();
                } else {
                    //Log::info("===========getKeyFromStock: check = false ===============");
                    $check = 0;
                }
            }
        }
        //Log::info("===========getKeyFromStock: return check ===============");
        //Log::info($check);
        return $check;
    }

    //Lấy premium gửi cho khách
    public function getPremiumKeySend($model_order) {
        if ($model_order) {
            $check = $this->checkKeyEnough($model_order);
            if ($check == 1) {//Nếu số key đã đủ để send cho khách
                $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model_order->id)->get();
                return $model_key;
            }
        }
        return null;
    }

    //Kiểm tra số lượng key đã đủ để có thể gửi cho khách
    public function checkKeyEnough($model_order) {
        if ($model_order) {
            $count_quantity = UserOrdersDetail::where("user_orders_id", "=", $model_order->id)->sum("quantity");
            $count_key = ArticlesTypeKey::where("user_orders_id", "=", $model_order->id)
                    ->whereNotNull("key")->where("key", "!=", "")
                    ->count();

            if ($count_quantity == $count_key) {
                return 1;
            }
        }
        return 0;
    }

    public function paySuccess() {
        return view('articles::invoice.paySuccess');
    }

}
