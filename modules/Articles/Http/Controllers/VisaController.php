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
use App\Models\KeyStock;
use App\Models\PaymentType;
use App\Models\StripeAccount;
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
    
    //HÀM CŨ TÍCH HỢP VỚI CỔNG VISA CỦA PHÁT
    public function checkoutCallback(Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();
            //Log::info($data);

            $seller_ref_code = (isset($data["seller_ref_code"])) ? $data["seller_ref_code"] : 0;
            $total_price = (isset($data["total_price"])) ? $data["total_price"] : 0;
            $tran_hash = (isset($data["tran_hash"])) ? $data["tran_hash"] : "";
            $tran_id = (isset($data["tran_id"])) ? $data["tran_id"] : "";
            $tran_ref = (isset($data["tran_ref"])) ? $data["tran_ref"] : "";
            $customer_email = (isset($data["customer_email"])) ? $data["customer_email"] : "";
            $extra_fields = (isset($data["extra_fields"])) ? $data["extra_fields"] : "";
            $secure_hash = (isset($data["secure_hash"])) ? $data["secure_hash"] : "";

            $status = (isset($data["status"])) ? $data["status"] : 0;

            $validate = md5(VISA_SELLER_ID . $seller_ref_code . $tran_hash . $total_price . $status . VISA_PRIVATE_KEY);

            if ($secure_hash == $validate) {

                //$model_log = new VisaPaymentLog();
                //$model_log->saveLog($data);
                $orderid_int = (int) $seller_ref_code;
                $model = UserOrders::find($orderid_int);

                if ($model) {
                    if ($status == 1 && $model->total_price == $total_price) {
                        $this->paymentByBonusVisa($model);

                        $keyStock = new KeyStock();
                        
                        //Trả key tự động thông qua link API
                        $keyStock->checkLinkApiProduct($model);
                        
                        $model_key = $keyStock->sendAndChangeStatusKey($model);
                        if ($model_key != null) {
                            $this->sendProductEmail($model, $model_key);
                        } else {
                            $this->sendMailPaid($model);
                            $keyStock->sendEmailOutOfStock($model);
                        }
                        //$this->sendEmailNotifyAdmin($model);
                        DB::commit();
                        return redirect()->route('frontend.invoice.view', ['id' => $model->id, 'email' => $model->email]);
                    } else {
                        Log::info("ERORR!!! DON HANG" . $seller_ref_code . " TRA VE LOI: " . $status . " TOTAL PRICE LA: " . $total_price);
                    }
                } else {
                    Log::info("ERORR!!! KHONG TIM THAY ORDER_ID LA: " . $seller_ref_code);
                }

                DB::commit();
            } else {
                Log::info("ERORR!!! VALIDATE KHONG DUNG: " . $seller_ref_code);
            }
            return redirect()->route('frontend.checkoutVisa.failure');
        }
    }
    //ĐANG CHẠY LIVE CHO CỔNG STRIPE CŨ
    public function callbackVisaStripe(Request $request) {
        if (isset($request)) {
            DB::beginTransaction();
            $data = $request->all();

            //Log::info("Checkout with Stripe");
            //Log::info($data);

            $id = (isset($data["id"])) ? $data["id"] : 0;
            $amount = (isset($data["amount"])) ? $data["amount"] : 0;
            $transaction_id = (isset($data["transaction_id"])) ? $data["transaction_id"] : "";
            $created = (isset($data["created"])) ? $data["created"] : "";
            $status = (isset($data["status"])) ? $data["status"] : "";
            $bpk_order_id = (isset($data["bpk_order_id"])) ? $data["bpk_order_id"] : 0;
            $bpk_private_key = (isset($data["bpk_private_key"])) ? $data["bpk_private_key"] : 0;

            $checkSignature = md5(VISA_CODE . $id . $transaction_id . $amount . $bpk_order_id . $created);
            if ($checkSignature == $bpk_private_key) {
                $model = UserOrders::find($bpk_order_id);

                if ($model) {
                    if ($status == "succeeded" && $model->total_price == $amount && $model->payment_status != "completed") {

                        //Them tien vao tong so du
                        $model_payment_type = new PaymentType();
                        $model_payment_type->saveMoneyTotal("VISA_STRIPE", $model->total_price);
                        
                        $model_stripe_account = new StripeAccount();
                        $model_stripe_account->saveMoneyStripeAccount($model);

                        $this->paymentByBonusVisa($model);

                        $keyStock = new KeyStock();
                        
                        //Trả key tự động thông qua link API
                        $keyStock->checkLinkApiProduct($model);
                        $model_key = $keyStock->sendAndChangeStatusKey($model);
                        if ($model_key != null) {
                            $this->sendProductEmail($model, $model_key);
                        } else {
                            $this->sendMailPaid($model);
                        }
                        //$this->sendEmailNotifyAdmin($model);
                        DB::commit();
                        return redirect()->route('frontend.invoice.view', ['id' => $model->id, 'email' => $model->email]);
                    } else {
                        Log::info("ERORR!!! DON HANG " . $bpk_order_id . " TRA VE LOI: " . $status . " TOTAL PRICE LA: " . $amount);
                        Log::info($data);
                        $model->payment_status = "echeck";
                        $model->save();
                        DB::commit();
                        return redirect()->route('frontend.invoice.paySuccess');
                    }
                } else {
                    Log::info("ERORR!!! KHONG TIM THAY ORDER_ID LA: " . $bpk_order_id);
                    Log::info($data);
                }
            } else {
                Log::info("Signature ERRROR");
                Log::info($data);
            }
        }
        Log::info("VISA STRIPE ERORR!!!");
        return redirect()->route('frontend.checkoutVisa.failure');
    }
    
    //Hàm tích hợp cổng thanh toán visa quickpay đã bỏ
    public function checkoutCallbackQuickPay(Request $request) {// Da bo
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
                //Log::info("Signature OKIEEEE");
                $model_log = new VisaPaymentLog();
                $model_log->saveLog($data);
                $orderid_int = (int) $orderid;
                $model = UserOrders::find($orderid_int);
                if ($model) {
                    if ($status == "Transaction Success" && $model->total_price == $total) {

                        //Tru tien neu khach hang dung them tien bonus o don hang truoc thanh toan cho don hang nay
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

    public function getCallbackVisaStripe() {
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

    public function sendEmailNotifyAdmin($model_orders) {
        try {
            $subject_email = "Customer PAY VISA for order: " . $model_orders->id;
            Mail::send('articles::checkoutVisa.email-notify-admin', ['model_orders' => $model_orders], function ($m) use ($subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to(EMAIL_RECEIVE_VISA, "Admin")->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
        }
    }

}
