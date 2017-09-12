<?php
namespace Modules\Articles\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Information;

class SiteMapController extends Controller {

    public function index()
    {
        $model_product = Articles::get();
        $model_product_detail = ArticlesType::get();

        $model_information = Information::get();


        return response()->view('articles::sitemap.list',
            compact(
                'model_product',
                'model_product_detail',
                'model_information'
            )
        )->header('Content-Type', 'text/xml');
    }
}

?>