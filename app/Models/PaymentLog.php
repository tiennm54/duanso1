<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model{
    protected $table = 'payments_log';
    public $timestamps = true;
    
    public function getPaymentType(){
        return $this->hasOne('App\Models\PaymentType', 'id' ,'	payments_type_id');
    }
}

