<?php

namespace Modules\Users\Http\Controllers;

use App\Models\ArticlesTypeKey;
use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use App\Models\UserOrdersHistory;
use Illuminate\Http\Request;
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
    public function listOrder(Request $request){
        $data = $request->all();
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoOrderHistory($model_seo);
        }
        $model_user = $this->checkMember();
        if ($model_user){
            $model = UserOrders::where("users_id","=", $model_user->id)->orderBy("id","DESC");
            if(isset($data["searchOrderNo"]) && $data["searchOrderNo"] != ""){
                $model = $model->where("order_no","LIKE", "%" . $data["searchOrderNo"] . "%");
            }
            if(isset($data["searchStatus"]) && $data["searchStatus"] != ""){
                $model = $model->where("payment_status","=",$data["searchStatus"]);
            }
            $model = $model->paginate(NUMBER_PAGE);
            
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

                $model_history = UserOrdersHistory::where("user_orders_id","=",$model->id)->get();

                return view('users::order-history.order-history-view',compact('model','model_order','model_key','model_history'));
            }
        }else{
            return redirect()->route('users.getLogin');
        }
    }

}