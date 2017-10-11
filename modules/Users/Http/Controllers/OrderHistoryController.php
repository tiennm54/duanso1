<?php

namespace Modules\Users\Http\Controllers;

use App\Models\ArticlesTypeKey;
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
use App\Helpers\SeoPage;


class OrderHistoryController extends CheckMemberController  {

    public function __construct(){
        $this->middleware("member");
    }

    public function seoOrderHistory($model_seo){
        $url_page = URL::route('users.orderHistory');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    // Khi login thì đã set session rồi
    public function listOrder(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoOrderHistory($model_seo);
        }
        $model_user = $this->checkMember();
        if ($model_user){
            $model = UserOrders::where("users_id","=", $model_user->id)->orderBy("id","DESC")->paginate(20);
            return view('users::order-history.order-history',compact('model'));
        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function seoViewOrderHistory($model_seo, $model){
        $url_page = URL::route('users.orderHistoryView', ['id'=> $model->id, 'order_no' => $model->order_no ]);
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function view($id){
        $model_seo = Seo::where("type","=","index")->first();
        $model_user = $this->checkMember();
        if ($model_user){
            $model = UserOrders::find($id);
            if ($model && $model->users_id == $model_user->id){

                if ($model_seo) {
                    $this->seoViewOrderHistory($model_seo, $model);
                }

                $model_order = UserOrdersDetail::where("user_orders_id","=",$model->id)
                    ->where("users_id","=", $model_user->id)
                    ->get();

                $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model->id)->get();

                return view('users::order-history.order-history-view',compact('model','model_order','model_key'));
            }
        }else{
            return redirect()->route('users.getLogin');
        }
    }

}