<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model {

    protected $table = 'payments_type';
    public $timestamps = false;

    public function getPaymentCharges($subTotal) {
        $fees = $this->fees;
        $plus = $this->plus;
        $payment_charges = round(($subTotal * $fees) / 100, 2) + $plus;
        return $payment_charges;
    }
    
    public function getPaymentTotal($subTotal){
        $charges = $this->getPaymentCharges($subTotal);
        $paymentTotal = $subTotal + $charges;
        return round($paymentTotal, 2);
    }

    public function saveMoneyTotal($payment_code, $money) {
        $model = PaymentType::where("code", "=", $payment_code)->first();
        if ($model) {
            $fees_service = $model->fees_service;
            $plus_service = $model->plus_service;
            $money_after_fees = $money - ($money * $fees_service / 100 + $plus_service);
            $model->money_total = $model->money_total + $money;
            $model->money_current = $model->money_current + $money_after_fees;
            $model->save();
        }
    }

    public function refundMoney($id, $money) {
        $model = PaymentType::find($id);
        if ($model) {
            $fees_service = $model->fees_service;
            $plus_service = $model->plus_service;
            $money_after_fees = $money - ($money * $fees_service / 100 + $plus_service);
            $model->money_total = $model->money_total - $money;
            $model->money_current = $model->money_current - $money_after_fees;
            $model->save();
        }
    }

    public function saveStatusDisable($status) {
        $this->status_disable = $status;
        $this->save();
    }

    public function sendEmailClosePaymentGateway() {
        try {
            $subject_email = "Cổng thanh toán: " . $this->title . " đã tự động đóng do nhận tiền quá hạn mức.";
            Mail::send('articles::platform.email-close-payment-gateway', ['name_payment_type' => $this->title], function ($m) use ($subject_email) {
                $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                $m->to(EMAIL_ADMIN_BUYPREMIUMKEY, "Admin")->subject($subject_email);
            });
        } catch (\Exception $e) {
            Log::info("LOI SEND EMAIL");
        }
    }

}
