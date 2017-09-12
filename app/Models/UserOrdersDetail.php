<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserOrdersDetail extends Model
{
    protected $table = 'user_orders_detail';
    public $timestamps = false;

    public function articles_type()
    {
        return $this->hasOne('App\Models\ArticlesType', 'id' ,'articles_type_id');
    }

    public function user_orders()
    {
        return $this->hasOne('App\Models\UserOrders', 'id' ,'user_orders_id');
    }

}