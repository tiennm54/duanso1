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
 *
 * @author minht
 */
class BonusPaymentHistory extends Model {

    //put your code here
    protected $table = 'bonus_payment_history';
    public $timestamps = true;
    
    public function getUserOrder(){
        return $this->hasOne('App\Models\UserOrders', 'id' ,'user_orders_id');
    }

}
