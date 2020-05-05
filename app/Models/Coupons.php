<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use URL;

class Coupons extends Model{
    protected $table = 'coupons';
    public $timestamps = true;
    
    public function getCouponsType() {
        return $this->hasOne('App\Models\CouponsType', 'id', 'coupons_type_id')->select("id", "title");
    }
}