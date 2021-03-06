<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class News extends Model{
    protected $table = 'news';
    public $timestamps = true;

    public function getProduct(){
        return $this->hasOne('App\Models\ArticlesType', 'id' ,'product_id');
    }
}