<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reviews;
use URL;
use Route;
/**
 * Description of ArticlesReviews
 *
 * @author minht
 */
class ArticlesReviews extends Model {

    protected $table = 'articles_reviews';
    public $timestamps = true;

    public function getArticles() {
        return $this->hasOne('App\Models\Articles', 'id', 'articles_id');
    }
    
    public function getUrlIndex(){
        return URL::route('product.reviews.index');
    }
    
    public function getUrl() {
        return URL::route('product.reviews.reviewsProduct', ['id' => $this->id, 'url' => $this->url_title . '.html']);
    }
    
    public function getRate(){
        $sum = 0;
        $page_url = "/reviews/premium-".$this->id."/".$this->url_title.".html";
        $obj_reviews = new Reviews();
        $data = $obj_reviews->countReviews($page_url);
        if(isset($data["sum"])){
            $sum = $data["sum"];
        }
        return $sum;
    }
}
