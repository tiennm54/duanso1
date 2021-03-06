<?php

namespace Modules\Users\Http\Controllers;
use App\Helpers\SeoPage;
use App\Models\ArticlesTypeKey;
use App\Models\Seo;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use Hash;
use Illuminate\Support\Facades\URL;
use Modules\Users\Http\Requests\GetKeyRequest;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class UserGetKeyController extends Controller {

    public function seoGetKey($model_seo){
        $url_page = URL::route('users.guestOrder.guestGetKey');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function guestGetKey(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoGetKey($model_seo);
        }
        $attributes = [
            'data-theme' => 'light',
            'data-type'	=>	'image',
        ];
        return view("users::getKey.get-key", compact('attributes'));
    }

    public function postGuestGetKey(GetKeyRequest $request){
        if(isset($request)) {
            $data = $request->all();
            $model = UserOrders::where("email","=", trim($data["email"]))->where("order_no","=",trim($data["order_no"]))->first();
            if($model != null){
                $model_order = UserOrdersDetail::where("user_orders_id","=",$model->id)->get();
                $model_key = ArticlesTypeKey::where("user_orders_id", "=", $model->id)->get();
                return view('users::order-history.order-history-view',compact('model','model_order','model_key'));
            }
        }

        $request->session()->flash('alert-warning', ' Warning: Wrong Email Address or Order No.');
        return back();
    }


}