<?php

namespace Modules\Users\Http\Controllers;

use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Mockery\CountValidator\Exception;
use Modules\Users\Http\Requests\LoginRequest;
use Modules\Users\Http\Requests\RegisterRequest;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\UserShoppingCart;
use DougSisk\CountryState\CountryState;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;


class OrderHistoryController extends CheckMemberController  {

    public function __construct(){
        $this->middleware("member");
    }

    // Khi login thì đã set session rồi
    public function listOrder(){

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            SEOMeta::setTitle("Order history Premium Key - ".$model_seo->seo_title);
            SEOMeta::setDescription($model_seo->seo_description);
            SEOMeta::addKeyword([$model_seo->seo_keyword]);
            SEOMeta::addMeta('article:published_time', $model_seo->created_at->toW3CString(), 'property');
            SEOMeta::addMeta('article:section', 'news', 'property');

            OpenGraph::setTitle($model_seo->seo_title);
            OpenGraph::setDescription($model_seo->seo_description);
            OpenGraph::setUrl(URL::route('frontend.articles.index'));
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png')]);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png'), 'size' => 300]);
            OpenGraph::addImage(url('theme_frontend/image/logo.png'), ['height' => 300, 'width' => 300]);
        }

        $model_user = $this->checkMember();
        if ($model_user){

            $model = UserOrders::where("users_id","=", $model_user->id)->orderBy("id","DESC")->paginate(20);


            return view('users::order-history.order-history',compact('model'));


        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function view($id){

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            SEOMeta::setTitle("View order history Premium Key ".$model_seo->seo_title);
            SEOMeta::setDescription($model_seo->seo_description);
            SEOMeta::addKeyword([$model_seo->seo_keyword]);
            SEOMeta::addMeta('article:published_time', $model_seo->created_at->toW3CString(), 'property');
            SEOMeta::addMeta('article:section', 'news', 'property');

            OpenGraph::setTitle($model_seo->seo_title);
            OpenGraph::setDescription($model_seo->seo_description);
            OpenGraph::setUrl(URL::route('frontend.articles.index'));
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png')]);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png'), 'size' => 300]);
            OpenGraph::addImage(url('theme_frontend/image/logo.png'), ['height' => 300, 'width' => 300]);
        }

        $model_user = $this->checkMember();
        if ($model_user){
            $model = UserOrders::find($id);
            if ($model && $model->users_id == $model_user->id){

                $model_order = UserOrdersDetail::where("user_orders_id","=",$model->id)
                    ->where("users_id","=", $model_user->id)
                    ->get();

                return view('users::order-history.order-history-view',compact('model','model_order'));
            }
        }else{
            return redirect()->route('users.getLogin');
        }
    }

}