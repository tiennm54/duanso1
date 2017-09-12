<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ArticlesType extends Model{
    protected $table = 'articles_type';
    public $timestamps = true;

    public function getArticles(){
        return $this->hasOne('App\Models\Articles', 'id' ,'articles_id');
    }

    public function getReview(){
        return $this->hasMany('App\Models\UserReview','articles_type_id','id');
    }

    public function getDescription(){
        return $this->hasMany('App\Models\ArticlesTypeDes','product_id','id');
    }
}