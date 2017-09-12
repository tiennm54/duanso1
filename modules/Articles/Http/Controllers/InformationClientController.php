<?php namespace Modules\Articles\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Response;
use Log;
use DB;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;

class InformationClientController extends Controller {
    public function view($id){
        $model = Information::find($id);
        if ($model){

            SEOMeta::setTitle($model->meta_tag_title);
            SEOMeta::setDescription($model->meta_tag_description);
            SEOMeta::addKeyword([$model->meta_tag_keyword]);
            SEOMeta::addMeta('article:published_time', $model->created_at, 'property');
            SEOMeta::addMeta('article:section', 'news', 'property');

            OpenGraph::setTitle($model->meta_tag_title);
            OpenGraph::setDescription($model->meta_tag_description);
            OpenGraph::setUrl(URL::route('frontend.articles.index'));
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png')]);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png'), 'size' => 300]);
            OpenGraph::addImage(url('theme_frontend/image/logo.png'), ['height' => 300, 'width' => 300]);

            return view("articles::information.view", compact('model'));
        }
        return redirect()->route('frontend.articles.index');
    }
}