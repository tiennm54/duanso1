<?php

namespace App\Models;

use App\Models\UserOrdersDetail;
use App\Models\ArticlesTypeKey;
use App\Models\UserOrdersHistory;
use App\Models\PaypalReceive;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Log;


class KeyStock extends Model {

    protected $table = 'key_stock';
    public $timestamps = true;
    
    public function sendMailPaid($model_orders) {
        try {
            $subject_email = SUBJECT_CUSTOMER_PAID . $model_orders->id;
            Mail::send('articles::platform.email-paid-successfully', ['model_orders' => $model_orders], function ($m) use ($model_orders, $subject_email) {
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
            Mail::send('articles::platform.email-sent-product', ['model_orders' => $model_orders, 'model_key' => $model_key], function ($m) use ($model_orders, $subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
            $model_orders->saveEmailDie(1);
        }
    }
    
    public function sendMailPaypalInvoice($model_orders, $model_user, $password, $payment_url) {
        try {
            $subject_email = SUBJECT_PAYPAL_PAYMENT . $model_orders->id;
            Mail::send('articles::platform.email-paypal-invoice', ['model_orders' => $model_orders, 'model_user' => $model_user, 'password' => $password, 'payment_url' => $payment_url], function ($m) use ($model_orders, $subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to($model_orders->email, $model_orders->first_name . " " . $model_orders->last_name)->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
            Log::info($e);
        }
    }
    
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

    public function getKeyFromStock($model_orders) {
        $check = 1;
        $model_articles_key = ArticlesTypeKey::where("user_orders_id", "=", $model_orders->id)->get();
        if ($model_articles_key != null) {
            foreach ($model_articles_key as $key => $item) {
                $model_stock = KeyStock::where("articles_type_id", "=", $item->articles_type_id)->where("status", "=", "Pending")->orderBy("id", "DESC")->first();
                if ($model_stock != null) {

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
                    $check = 0;
                }
            }
        }
        return $check;
    }

    // GUI KEY DI VA CAP NHAT TRANG THAI KEY THANH DA SENT
    public function sendAndChangeStatusKey($model) {
        
        $model_orders_history = new UserOrdersHistory();
        $obj_paypal_history = new PaypalReceive();
        
        $check_send_key = $this->getKeyFromStock($model);
        
        
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

                
                $model_orders_history->saveHistoryOrder($model);
                $obj_paypal_history->saveHistoryReceive($model, "completed");

                return $model_key;
            }
        } else {
            $model->payment_status = "paid";
            $model->save();
            $model_orders_history->saveHistoryOrder($model);
            return null;
        }
        return null;
    }

}
