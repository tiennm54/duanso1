<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model{
    protected $table = 'payments_type';
    public $timestamps = false;
    
    
    public function saveMoneyTotal($payment_code, $money){
        $model = PaymentType::where("code","=",$payment_code)->first();
        if($model){
            $fees_service = $model->fees_service;
            $plus_service = $model->plus_service;
            $money_after_fees = $money - ($money * $fees_service / 100 + $plus_service);
            $model->money_total	= $model->money_total + $money;
            $model->money_current = $model->money_current + $money_after_fees;
            $model->save();
        }
    }
    
    public function refundMoney($id, $money){
        $model = PaymentType::find($id);
        if($model){
            $fees_service = $model->fees_service;
            $plus_service = $model->plus_service;
            $money_after_fees = $money - ($money * $fees_service / 100 + $plus_service);
            $model->money_total	= $model->money_total - $money;
            $model->money_current = $model->money_current - $money_after_fees;
            $model->save();
        }
    }
    
    public function saveStatusDisable($status){
        $this->status_disable = $status;
        $this->save();
    }
    
}