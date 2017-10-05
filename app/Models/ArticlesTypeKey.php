<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticlesTypeKey extends Model{
    protected $table = 'articles_type_key';
    public $timestamps = true;

    public function getProduct(){
        return $this->hasOne('App\Models\ArticlesType', 'id' ,'articles_type_id');
    }

    public function getUserOrders(){
        return $this->hasOne('App\Models\UserOrders', 'id' ,'user_orders_id');
    }

}