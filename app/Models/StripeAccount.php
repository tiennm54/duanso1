<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\PaymentType;

class StripeAccount extends Model {

    protected $table = 'stripe_account';
    public $timestamps = false;
    
    public function saveMoneyStripeAccount($modelOrder){
        $money = $modelOrder->total_price;
        $model = $modelOrder->stripeAccount;
        if($model){
            
            $model_payment_type = PaymentType::where("code","=","VISA_STRIPE")->first();
            $fees_service = 0;
            $plus_service = 0;
            if($model_payment_type){
                $fees_service = $model_payment_type->fees_service;
                $plus_service = $model_payment_type->plus_service;
            }
            $money_after_fees = $money - ($money * $fees_service / 100 + $plus_service);
            $model->total_money = $model->total_money + $money_after_fees;
            $model->save();
        }
    }
}
