<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use URL;

class Category extends Model{
    protected $table = 'category';
    public $timestamps = false;
    
    public function getUrl(){
        return URL::route('frontend.news.cate',["id"=> $this->id, 'url'=>$this->path_url.".html"]);
    }
}