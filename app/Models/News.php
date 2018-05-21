<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use URL;

class News extends Model{
    protected $table = 'news';
    public $timestamps = true;

    public function getProduct(){
        return $this->hasOne('App\Models\Articles', 'id' ,'product_id');
    }
    
    public function getCategory(){
        return $this->hasOne('App\Models\Category', 'id' ,'category_id');
    }
    
    public function getUrl(){
        return URL::route('frontend.news.view',["id"=> $this->id, 'url'=>$this->url_title.".html"]);
    }
    
}