<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserShippingAddress extends Model
{
    protected $table = 'user_shipping_address';
    public $timestamps = true;
}