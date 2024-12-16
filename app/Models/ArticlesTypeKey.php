<?php

namespace App\Models;

use App\Models\Faq;
use App\Models\Articles;
use App\Models\ArticlesType;
use Illuminate\Database\Eloquent\Model;
use Log;

class ArticlesTypeKey extends Model {

    protected $table = 'articles_type_key';
    public $timestamps = true;

    public function getProduct() {
        return $this->hasOne('App\Models\ArticlesType', 'id', 'articles_type_id');
    }

    public function getUserOrders() {
        return $this->hasOne('App\Models\UserOrders', 'id', 'user_orders_id');
    }

    public function getLinkActivate() {
        $model_article_type = ArticlesType::find($this->articles_type_id);
        if ($model_article_type) {
            $model_product = $model_article_type->getArticles;
            if ($model_product) {
                $model = Faq::where("product_id", "=", $model_product->id)->first();
                if ($model) {
                    return $model;
                }
            }
        }
        return null;
    }

}
