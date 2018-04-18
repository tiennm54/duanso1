<?php

namespace App\Helpers;

use SEOMeta;
use OpenGraph;
use Twitter;
use App\Models\Seo;
use URL;

class SeoPage {

    public static function createSeo($model_seo, $url_page, $image_page) {
        SEOMeta::setTitle($model_seo->seo_title);
        SEOMeta::setDescription($model_seo->seo_description);
        SEOMeta::addKeyword([$model_seo->seo_keyword]);
        SEOMeta::addMeta('article:published_time', $model_seo->created_at, 'property');
        SEOMeta::addMeta('article:section', 'news', 'property');
        SEOMeta::setCanonical($url_page);

        OpenGraph::setTitle($model_seo->seo_title);
        OpenGraph::setDescription($model_seo->seo_description);
        OpenGraph::setUrl($url_page);
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'pt-br');
        OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
        OpenGraph::addImage(['url' => $image_page]);
        OpenGraph::addImage($image_page, ['height' => 630, 'width' => 1200]);
        //OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png'), 'size' => 300]);

        Twitter::setTitle($model_seo->seo_title);
        Twitter::setDescription($model_seo->seo_description);
        Twitter::setUrl($url_page);
        Twitter::setImage($image_page);
    }

    public static function seoPage($model_route) {
        $route_current = $model_route->getRouter()->getCurrentRoute()->getName();
        $model = Seo::where("page_code", "=", $route_current)->first();
        if ($model == null) {
            $model = Seo::where("page_code", "=", "frontend.articles.index")->first();
        }
        if ($model != null) {
            $url_page = URL::route($route_current);
            $image_page = url('images/seo/' . $model->image);
            SeoPage::createSeo($model, $url_page, $image_page);
        }
    }

}
