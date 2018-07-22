<?php

namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Information;
use App\Models\Category;
use App\Models\News;
use App\Models\CategoryFaq;
use App\Models\Faq;
use App\Models\ArticlesReviews;

class SiteMapController extends Controller {

    public function index() {
        $model_product = Articles::get();
        $model_product_detail = ArticlesType::get();
        $model_information = Information::get();
        $model_cate = Category::get();
        $model_news = News::get();
        $model_cate_faq = CategoryFaq::get();
        $model_faq = Faq::get();
        $model_product_reviews = ArticlesReviews::get();

        return response()->view('articles::sitemap.list', compact(
                'model_product', 
                'model_product_detail', 
                'model_information', 
                'model_cate', 
                'model_news',
                'model_cate_faq',
                'model_faq',
                'model_product_reviews'
                ))->header('Content-Type', 'text/xml');
    }

}

?>