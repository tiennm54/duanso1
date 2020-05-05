<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use URL;

class CouponsType extends Model {

    protected $table = 'coupons_type';
    public $timestamps = true;

    /*public function sendEmail() {
        $emails = ['myoneemail@esomething.com', 'myother@esomething.com', 'myother2@esomething.com'];

        Mail::send('emails.welcome', [], function($message) use ($emails) {
            $message->to($emails)->subject('This is test e-mail');
        });
        var_dump(Mail:: failures());
        exit;
    }*/

}
