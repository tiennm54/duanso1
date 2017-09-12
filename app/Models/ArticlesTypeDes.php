<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticlesTypeDes extends Model{
    protected $table = 'articles_type_des';
    public $timestamps = false;
    public function getProduct(){
        return $this->hasOne('App\Models\ArticlesType', 'id' ,'articles_type_id');
    }



}