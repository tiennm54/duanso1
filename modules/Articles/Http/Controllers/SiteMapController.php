<?php

namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Information;
use App\Models\Category;
use App\Models\News;

class SiteMapController extends Controller {

    public function index() {
        $model_product = Articles::get();
        $model_product_detail = ArticlesType::get();
        $model_information = Information::get();
        $model_cate = Category::get();
        $model_news = News::get();

        return response()->view('articles::sitemap.list', compact(
                                'model_product', 'model_product_detail', 'model_information', 'model_cate', 'model_news'
                        )
                )->header('Content-Type', 'text/xml');
    }

}

?>