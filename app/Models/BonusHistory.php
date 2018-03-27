<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Log;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of BonusHistory
 *
 * @author minht
 */
class BonusHistory extends Model {

    protected $table = 'bonus_history';
    public $timestamps = true;

    public function getUserBuy() {
        return $this->hasOne('App\Models\User', 'id', 'user_buy_id');
    }

    public function getUserSponser() {
        return $this->hasOne('App\Models\User', 'id', 'user_sponser_id');
    }

    public function getOrder() {
        return $this->hasOne('App\Models\UserOrders', 'id', 'user_order_id');
    }

    //Lưu lịch sử bonus cho người dùng
    public function saveBonusHistory($model_orders, $user_buy_id, $user_sponser_id, $bonus_money, $bonus_type, $bonus_percent) {
        $this->user_buy_id = $user_buy_id;
        $this->user_sponser_id = $user_sponser_id;
        $this->user_order_id = $model_orders->id;
        $this->bonus = $bonus_money;
        $this->bonus_type = $bonus_type;
        $this->bonus_percent = $bonus_percent;
        $this->save();
        return $this;
    }

}
