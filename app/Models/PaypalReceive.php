<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PaypalAccount;
use Log;

class PaypalReceive extends Model {

    protected $table = 'paypal_receive';
    public $timestamps = true;

    public function getPaypalAccount() {
        return $this->hasOne('App\Models\PaypalAccount', 'id', 'paypal_account_id');
    }
    
    public function getOrder() {
        return $this->hasOne('App\Models\UserOrders', 'id', 'order_id');
    }

    public function saveHistoryReceive($model_order, $status) {
        $model_paypal_account = PaypalAccount::find($model_order->paypal_account_id);
        if ($model_paypal_account && $model_order->status != "completed") {
            $this->order_id = $model_order->id;
            $this->order_no = $model_order->order_no;
            $this->paypal_account_id = $model_paypal_account->id;
            $this->paypal_account_email = $model_paypal_account->email;
            $this->email_paid = $model_order->email;
            $this->total = $model_order->total_price;
            $this->total_receive = ($model_order->total_price - (($model_order->total_price * RATE_PAYPAL) / 100 + 0.3));
            $this->status = $status;
            $this->save();
            if ($status == "activate") {
                $model_paypal_account->money_activate = $model_paypal_account->money_activate + $this->total_receive;
            }else{
                $model_paypal_account->money_hold = $model_paypal_account->money_hold + $this->total_receive;
            }
            $model_paypal_account->save();
        }else{
            Log::info("Vao day");
        }
    }

}
