<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StripeAccountPO extends Model {

    protected $table = 'stripe_account_po';
    public $timestamps = true;
    
    public function saveMoneyPO($modelStripe, $money, $dateAdd){
        
    }
}
