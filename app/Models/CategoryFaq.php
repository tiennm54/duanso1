<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use URL;

class CategoryFaq extends Model{
    protected $table = 'category_faq';
    public $timestamps = false;
    
    public function getUrl(){
        return URL::route('frontend.faq.cate',["id"=> $this->id, 'url'=>$this->url_title.".html"]);
    }
}