<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use URL;
use App\Models\PaymentType;
use App\Models\PaypalAccount;
use Log;

class UserOrders extends Model {

    protected $table = 'user_orders';
    public $timestamps = true;

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'users_id');
    }

    public function payment_type() {
        return $this->hasOne('App\Models\PaymentType', 'id', 'payments_type_id');
    }

    public function paypalAccount() {
        return $this->hasOne('App\Models\PaypalAccount', 'id', 'paypal_account_id');
    }

    public function orders_detail() {
        return $this->hasMany('App\Models\UserOrdersDetail', 'user_orders_id', 'id');
    }

    //LAY ORDER NO CHO ORDER
    public function getNameOrderNo($model_paypal_account) {
        $prefix = "BPK-";
        if ($model_paypal_account != null) {
            if ($model_paypal_account->prefix != null && $model_paypal_account->prefix != "") {
                $prefix = $model_paypal_account->prefix . "-";
            }
        }
        $order_no = $prefix . $this->id;
        return $order_no;
    }
    //Tim email se nhan thanh toan tu khach hang dua tren so tien khach hang thanh toan
    public function getEmailPaypal($total_price, $model_payment_type){
        
        $model_acc_1 = PaypalAccount::find($model_payment_type->paypal_account_id);
        
        if($model_acc_1 != null){
            if($model_acc_1->max_money >= $total_price){
                
                return $model_acc_1;
                
            }else{
                
                $model_acc_2 = PaypalAccount::where("max_money", ">=", $total_price)
                ->where("status", "=", "Work")
                ->orderBy('money_activate', 'ASC')
                ->first();
                
                if($model_acc_2 != null){
                    
                    return $model_acc_2;
                    
                }else{
                    
                    $model_acc_3 = PaypalAccount::where("status", "=", "Work")
                    ->orderBy('max_money', 'DESC')
                    ->orderBy('money_activate', 'ASC')
                    ->first();
                    if($model_acc_3 != null){
                        
                        return $model_acc_3;
                    
                    }
                }
            }
        }
        
        return $model_acc_1;
    }

    public function createPaypalToken() {
        $time = strtotime(Carbon::now());
        $order_id = $this->id;
        $total_price = $this->total_price;
        $private_key = PRIVATE_PAYPAL_KEY;
        $string_hash = $private_key . "-" . $order_id . "-" . $total_price . "-" . $time;
        //Log::info($string_hash);
        $paypal_token = base64_encode($string_hash);
        return $paypal_token;
    }
    
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function createOrder($model_user, $money_user, $data, $array_orders, $totalOrder) {

        if ($model_user->status_lock == 1) {//Tài khoản đã bị khóa
            return null;
        }

        if ($totalOrder['payment_code'] == "BONUS" || $totalOrder["used_bonus"] > 0) {
            $check_money = $model_user->getMoneyAccountCurrent();
            //Log::info($check_money);
            //Log::info($money_user);
            if ($check_money != $money_user) {
                $model_user->saveLockStatus();
                return null;
            }
        }

        $model_payment_type = PaymentType::find($data["payments_type_id"]);
        if ($model_payment_type == null) {
            return null;
        }
        $model_paypal_account = $this->getEmailPaypal($totalOrder["total"], $model_payment_type);
        
        $this->paypal_account_id = $model_paypal_account->id;
        $this->paypal_email = $model_paypal_account->email;

        $this->users_id = $model_user->id;
        $this->users_roles_id = $model_user->roles_id;
        $this->first_name = $model_user->first_name;
        $this->last_name = $model_user->last_name;
        $this->email = $data["email"];
        $this->first_name = $data["first_name"];
        $this->last_name = $data["last_name"];
        $this->payments_type_id = $data["payments_type_id"];
        $this->sub_total = $totalOrder["sub_total"];
        $this->payment_charges = $totalOrder["charges"]; // Tien phi
        $this->used_bonus = $totalOrder["used_bonus"]; // Su dung tien bonus de thanh toan
        $this->total_price = $totalOrder["total"];
        $this->quantity_product = count($array_orders);
        $this->payment_status = "pending";
        $this->user_ip = $this->get_client_ip();
        
        $this->save();
        $this->order_no = $this->getNameOrderNo($model_paypal_account);
        $this->paypal_token = $this->createPaypalToken();
        $this->save();
        //Save Order Detail
        foreach ($array_orders as $item) {
            $model_user_orders_detail = new UserOrdersDetail();
            $model_user_orders_detail->user_orders_id = $this->id;
            $model_user_orders_detail->users_id = $model_user->id;
            $model_user_orders_detail->users_roles_id = $model_user->roles_id;
            $model_user_orders_detail->articles_type_id = $item["id"];
            $model_user_orders_detail->title = $item["title"];
            $model_user_orders_detail->image = $item["image"];
            $model_user_orders_detail->quantity = $item["quantity"];
            $model_user_orders_detail->price_order = $item["price_order"];
            $model_user_orders_detail->total_price = $item["total"];
            $model_user_orders_detail->save();
            for ($i = 0; $i < $item["quantity"]; $i++) {
                $model_premium_key = new ArticlesTypeKey();
                $model_premium_key->user_orders_id = $this->id;
                $model_premium_key->user_orders_detail_id = $model_user_orders_detail->id;
                $model_premium_key->articles_type_id = $model_user_orders_detail->articles_type_id;
                $model_premium_key->articles_type_title = $model_user_orders_detail->title;
                $model_premium_key->articles_type_price = $model_user_orders_detail->price_order;
                $model_premium_key->status = "none";
                $model_premium_key->save();
            }
        }
        return $this;
    }

    //Update lại tài khoản nếu có nghi vấn thì update trong user
    public function cancelRefundOrder($type, $model_user) {
        if ($model_user) {
            $total_refund = 0;
            $payment_code = $this->payment_type->code;

            if ($payment_code == "BONUS") {
                $total_refund = $this->total_price;
            } else {
                $total_refund = $this->used_bonus;
            }

            $total_after_refund = $model_user->getMoneyAccountCurrent() + $total_refund;
            $model_user->updateMoneyForUser($total_after_refund);

            $this->payment_status = $type;
            $this->save();
            BonusPaymentHistory::where("user_orders_id", "=", $this->id)->update(["status" => $type]);
            return true;
        }
        return false;
    }

    public function getOrderPending() {
        $model = UserOrders::where("payment_status", "pending")->orderBy('id', 'DESC')->paginate(5);
        return $model;
    }

    public function getOrderPaid() {
        $model = UserOrders::where(function ($query) {
                    $query->where('payment_status', 'paid')
                            ->orWhere('payment_status', 'dispute')
                            ->orWhere('payment_status', 'echeck');
                })->orderBy('id', 'DESC')->paginate(10);
        return $model;
    }

    public function getOrderCompletedDay() {
        $model = UserOrders::where("payment_status", "completed")
                ->where('payment_date', '>=', date('Y-m-d') . ' 00:00:00')
                ->orderBy('id', 'DESC')
                ->get();
        return $model;
    }

    public function getTotalOrderMoney() {
        //Tiền thanh toán
        $money_order = UserOrders::where("payment_status", "completed")->sum('total_price');
        //Tiền thực nhận sau khi trừ 3.9% + 0.3$ phí
        $charge = ( ($money_order * 4) / 100 );
        $money = $money_order - $charge;
        $money = number_format($money, 2);
        $money_order = number_format($money_order, 2);
        $data = array(
            "money_order" => $money_order,
            "money" => $money
        );
        return $data;
    }

    public function getUrl() {
        return URL::route('users.orderHistoryView', ["id" => $this->id, "order_no" => $this->order_no]);
    }

}
