<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaypalAccount extends Model {

    protected $table = 'paypal_account';
    public $timestamps = false;

    public function updateTimeActivate() {
        $this->start_date = Carbon::now();
        $this->end_date = Carbon::now();
        $this->save();
    }

}
