<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalSell extends Model {
    protected $table = 'paypal_sell';
    public $timestamps = true;
    
    public function getPaypalAccount(){
        return $this->hasOne('App\Models\PaypalAccount', 'id' ,'paypal_account_id');
    }
}
