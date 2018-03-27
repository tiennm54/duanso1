<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of BonusPaymentHistory
 * SAVE LỊCH SỬ CHI TIÊU CỦA KHÁCH HÀNG - SPENDING
 * @author minht
 */
class BonusPaymentHistory extends Model {

    //put your code here
    protected $table = 'bonus_payment_history';
    public $timestamps = true;

    public function getUserOrder() {
        return $this->hasOne('App\Models\UserOrders', 'id', 'user_orders_id');
    }

    public function saveHistorySpending($model_order, $model_user, $payment_code) {
        $total_payment = 0;
        //Lấy tiền trước khi thanh toán
        $total_money = $model_user->getMoneyForUser();
        //Tien thanh toans
        if ($payment_code == "BONUS") {
            $total_payment = $model_order->total_price;
        } else {
            $total_payment = $model_order->used_bonus;
        }
        //Ghi log
        $this->user_orders_id = $model_order->id;
        $this->user_id = $model_user->id;
        $this->total_payment = $total_payment; //Số tiền bonus sử dụng để thanh toán
        $this->total_before = $total_money; // Số tiền trước thanh toán
        $this->total_after = $total_money - $total_payment; // Số tiền còn lại sau khi thanh toán
        $this->status = "pending";
        $this->save();
        $model_user->updateSessionMoney($this->total_after);
        
        $money_current = $model_user->user_money;
        $money_update = $money_current - $total_payment;
        $model_user->updateMoneyForUser($money_update);
        
        return $this;
    }

}
