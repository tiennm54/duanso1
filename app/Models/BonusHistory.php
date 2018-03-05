<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

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

}
