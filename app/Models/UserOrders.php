<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserOrders extends Model
{
    protected $table = 'user_orders';
    public $timestamps = true;


    public function user()
    {
        return $this->hasOne('App\Models\User', 'id' ,'users_id');
    }

    public function payment_type()
    {
        return $this->hasOne('App\Models\PaymentType', 'id' ,'payments_type_id');
    }

    public function orders_detail(){
        return $this->hasMany('App\Models\UserOrdersDetail','user_orders_id','id');
    }

}