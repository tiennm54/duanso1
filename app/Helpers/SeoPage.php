<?php namespace App\Helpers;
use SEOMeta;
use OpenGraph;
use Twitter;

class SeoPage{

    public static function createSeo($model_seo, $url_page, $image_page){
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
        //OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png'), 'size' => 300]);
        OpenGraph::addImage($image_page, ['height' => 300, 'width' => 600]);

        Twitter::setTitle($model_seo->seo_title);
        Twitter::setDescription($model_seo->seo_description);
        Twitter::setUrl($url_page);
        Twitter::setImage($image_page);
    }
}