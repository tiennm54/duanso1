<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserShoppingCart extends Model{
    protected $table = 'user_shopping_cart';
    public $timestamps = true;

    public function getArticlesType(){
        return $this->hasOne('App\Models\ArticlesType', 'id' ,'articles_type_id');
    }


    public function getShoppingOrder($model_user){
        $model_list_order =  UserShoppingCart::where("user_id","=", $model_user->id)->where("status_payment","=","NotCheckout")->get();
        $array_orders = array();
        foreach ($model_list_order as $item){
            $orders = array(
                "id" => $item->articles_type_id,
                "title" => $item->getArticlesType->title,
                "image" => url('images/'. $item->getArticlesType->getArticles->image),
                "quantity" => $item->quantity,
                "price_order" => $item->getArticlesType->price_order,
                "total" => ($item->getArticlesType->price_order * $item->quantity),
            );
            array_push($array_orders, $orders);
        }
        return $array_orders;
    }

    public function getItemProductOrder($model_user, $model_articles_type){
        $model_shopping = UserShoppingCart::where("articles_type_id","=",$model_articles_type->id)
            ->where("user_id","=",$model_user->id)
            ->where("status_payment","=","NotCheckout")
            ->first();
        return $model_shopping;
    }

    public function emptyShoppingCart($model_user){
        UserShoppingCart::where("user_id","=",$model_user->id)->where("status_payment","=","NotCheckout")->delete();
    }

    //Tính tổng giá trị sản phẩm
    public function getSubTotal($listOrder){
        $sum = 0;
        foreach ($listOrder as $item){
            $sum = $sum + $item["total"];
        }
        return $sum;
    }

    public function setSession($array_orders){

        $subTotal = $this->getSubTotal($array_orders);
        $quatityItem = count($array_orders);

        Session::set('array_orders', $array_orders);
        Session::set('sub_total', $subTotal);
        Session::set('quantity_item', $quatityItem);
    }

    public function emptySession(){
        Session::set('array_orders', []);
        Session::set('sub_total', 0);
        Session::set('quantity_item', 0);
    }
}