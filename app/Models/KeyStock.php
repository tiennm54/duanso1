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

    public function sendEmailCheckOrder($email_customer, $transaction_id) {
        try {
            $subject_email = "Cần kiểm tra đơn hàng của khách hàng: " . $email_customer;
            Mail::send('articles::platform.email-check-order', ['email_customer' => $email_customer, "transaction_id" => $transaction_id], function ($m) use ($subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to(EMAIL_ADMIN_BUYPREMIUMKEY, "Admin")->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
        }
    }
    
    //Thong bao khi het hang
    public function sendEmailOutOfStock($model_orders) {
        try {
            $subject_email = "Notify Keys Product";
            Mail::send('articles::platform.email-out-of-stock', ['order_id' => $model_orders->id], function ($m) use ($subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to(EMAIL_ADMIN_BUYPREMIUMKEY, "Admin")->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
        }
    }

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

    /////////////////////////////////////////////////////////////////////////////
    //LÀM TÍNH NĂNG GET KEY TỰ ĐỘNG THÔNG QUA API
    /////////////////////////////////////////////////////////////////////////////

    public function getKeyViaAPI($linkAPI) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $linkAPI);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "Accept: application/json"
                ));
            $key = curl_exec($ch);
            if ($key && is_string($key) === true && strpos($key, 'ERROR') === false && strpos($key, 'you have been blocked') === false && strpos($key, 'DOCTYPE') === false && strpos($key, '<html>') === false) {
                Log::info("DA LAY DUOC KEY API THANH CONG... ");
                Log::info($key);
                return $key;
            } else {
                Log::info("ERROR GET KEY API");
                Log::info($linkAPI);
                Log::info($key);
                return null;
            }
        } catch (Exception $ex) {
            Log::info("ERRORR GET KEY VIA API");
        }
        return null;
    }

    //Tự động save key lấy được thông qua API vào Kho tương ứng với sản phẩm
    public function saveKeyToStock($model_product, $premiumKey) {
        $this->articles_type_id = $model_product->id;
        $this->articles_type_title = $model_product->title;
        $this->premium_key = $premiumKey;
        $this->status_paid = 0;
        $this->status = "Pending";
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
        $this->save();
    }
    
    //Hàm kiểm tra sản phẩm có gắn API không? Đồng thời save Key nếu có
    public function checkLinkApiProduct($model_order) {
        //Check sản phẩm trong đơn hàng
        $model_order_detail = UserOrdersDetail::where("user_orders_id", "=", $model_order->id)->get();
        if ($model_order_detail) {
            foreach ($model_order_detail as $item) {
                //Lấy sản phẩm trong đơn hàng
                $model_product = ArticlesType::find($item->articles_type_id);
                if ($model_product) {
                    if ($model_product->api_link != null && $model_product->api_link != "") {
                        if ($model_product->api_link_status == 1) {// Cho phép lấy key thông qua API
                            //Lấy premium key theo số lượng product
                            for ($i = 0; $i < $item->quantity; $i++) {
                                $premiumKey = $this->getKeyViaAPI($model_product->api_link);
                                if ($premiumKey) {
                                    $model_key = new KeyStock();
                                    $model_key->saveKeyToStock($model_product, $premiumKey);
                                    Log::info("ĐÃ SAVE KEY VÀO STOCK HOÀN THÀNH");
                                    Log::info($premiumKey);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}
