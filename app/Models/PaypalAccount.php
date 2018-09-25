<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaypalAccount extends Model {
    protected $table = 'paypal_account';
    public $timestamps = false;
    
    public function updatePaypalAccount($money, $status){
        switch($status){
            
        }
    }
}
