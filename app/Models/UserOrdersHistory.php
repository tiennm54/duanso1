<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserOrdersHistory extends Model
{
    protected $table = 'user_orders_history';
    public $timestamps = true;
}