<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\UserShoppingCart;
use Illuminate\Support\Facades\Session;
use Modules\Users\Http\Controllers\CheckMemberController;
use Illuminate\Http\Request;
use DB;

class ShoppingCartController extends CheckMemberController {

    //KHÁCH VÃNG LAI
    public function addToCartForGuest($model_articles_type) {
        $orders = array(
            "id" => $model_articles_type->id,
            "title" => $model_articles_type->title,
            "image" => url('images/' . $model_articles_type->getArticles->image),
            "quantity" => 1,
            "price_order" => $model_articles_type->price_order,
            "total" => $model_articles_type->price_order,
        );

        $array_orders = Session::get('array_orders', []);

        //Kiểm tra nếu đã tồn tại thì tăng số lượng
        //Ngược lại thì add thêm vào giỏ hàng
        $check = 0;
        foreach ($array_orders as &$item) {
            if ($item["id"] == $model_articles_type->id) {
                $check = 1;
                $item["quantity"] = $item["quantity"] + 1;
                $item["total"] = $item["total"] + $orders["total"];
            }
        }

        if ($check == 0) {
            array_push($array_orders, $orders);
        }

        return $array_orders;
    }

    //MEMBER
    public function addToCartForMember($model_user, $model_articles_type) {
        DB::beginTransaction();
        $obj_shopping_cart = new UserShoppingCart();
        $model_shopping = $obj_shopping_cart->getItemProductOrder($model_user, $model_articles_type);

        if ($model_shopping) {
            $model_shopping->quantity = $model_shopping->quantity + 1;
            $model_shopping->save();
        } else {
            $model_shopping = new UserShoppingCart();
            $model_shopping->user_id = $model_user->id;
            $model_shopping->articles_type_id = $model_articles_type->id;
            $model_shopping->quantity = 1;
            $model_shopping->save();
        }


        $array_orders = $obj_shopping_cart->getShoppingOrder($model_user);

        DB::commit();
        return $array_orders;
    }

    //Đưa sản phẩm vào giỏ hàng. Hàng động By Now
    public function addToCart(Request $request) {
        $data = $request->all();
        if (isset($data["product_id"])) {
            $model_articles_type = ArticlesType::find($data["product_id"]);
            if ($model_articles_type && $model_articles_type->status_stock == 1) {
                $model = $this->checkMember();
                if ($model) {
                    $array_orders = $this->addToCartForMember($model, $model_articles_type);
                } else {
                    $array_orders = $this->addToCartForGuest($model_articles_type);
                }
                $obj_shopping_cart = new UserShoppingCart();
                $data_product = $array_orders;
                $obj_shopping_cart->setSession($data_product);
                $subTotal = Session::get('sub_total');
                $quantityItem = Session::get('quantity_item');
                return view('articles::append.addToCart', compact('data_product', 'subTotal', 'quantityItem'));
            }
        }
        return redirect()->route('frontend.articles.index');
    }

    public function buyNow($id) {
        $model_articles_type = ArticlesType::find($id);
        if ($model_articles_type && $model_articles_type->status_stock == 1) {
            $model = $this->checkMember();
            if ($model) {
                $array_orders = $this->addToCartForMember($model, $model_articles_type);
            } else {
                $array_orders = $this->addToCartForGuest($model_articles_type);
            }
            $obj_shopping_cart = new UserShoppingCart();
            $obj_shopping_cart->setSession($array_orders);
            return redirect()->route('frontend.checkout.index');
        }
        return redirect()->route('frontend.articles.index');
    }

    public function deleteSessionOrderForGuest($model_articles_type) {
        $array_orders = Session::get('array_orders', []);
        foreach ($array_orders as $key => $item) {
            if ($item["id"] == $model_articles_type->id) {
                unset($array_orders[$key]);
            }
        }
        return $array_orders;
    }

    public function deleteSessionOrderForMember($model_user, $model_articles_type) {

        DB::beginTransaction();
        $obj_shopping_cart = new UserShoppingCart();

        $model_shopping = $obj_shopping_cart->getItemProductOrder($model_user, $model_articles_type);
        if ($model_shopping) {
            $model_shopping->delete();
        }

        $array_orders = $obj_shopping_cart->getShoppingOrder($model_user);

        DB::commit();
        return $array_orders;
    }

    //Action: Xóa một sản phẩm trong giỏ hàng
    public function deleteSessionOrder(Request $request) {
        $data = $request->all();
        if (isset($data["id"])) {
            $id = $data["id"];
            $model_articles_type = ArticlesType::find($id);
            if ($model_articles_type) {

                //Nếu là member
                $model_user = $this->checkMember();
                if ($model_user) {
                    $array_orders = $this->deleteSessionOrderForMember($model_user, $model_articles_type);
                } else {
                    $array_orders = $this->deleteSessionOrderForGuest($model_articles_type);
                }

                $obj_shopping_cart = new UserShoppingCart();
                $data_product = $array_orders;
                $obj_shopping_cart->setSession($data_product);
                $subTotal = Session::get('sub_total');
                $quantityItem = Session::get('quantity_item');

                return view('articles::append.addToCart', compact('data_product', 'subTotal', 'quantityItem'));
            }
        }

        return redirect()->route('frontend.articles.index');
    }

    public function changeNumberProductOrderForGuest($model_articles_type, $number) {
        $array_orders = Session::get('array_orders', []);
        foreach ($array_orders as &$item) {
            if ($item["id"] == $model_articles_type->id) {
                $item["quantity"] = $number;
                $item["total"] = $item["price_order"] * $number;
            }
        }

        return $array_orders;
    }

    public function changeNumberProductOrderForMember($model_user, $model_articles_type, $number) {

        DB::beginTransaction();
        $obj_shopping_cart = new UserShoppingCart();

        $model_shopping = $obj_shopping_cart->getItemProductOrder($model_user, $model_articles_type);

        if ($model_shopping) {
            $model_shopping->quantity = $number;
            $model_shopping->save();
        }


        $array_orders = $obj_shopping_cart->getShoppingOrder($model_user);

        DB::commit();
        return $array_orders;
    }

    //Hàm thực hiện khi thay đổi số lượng sản phẩm trên popup order
    public function changeNumberProductOrder(Request $request) {
        $data = $request->all();

        if (isset($data["id"]) && isset($data["number"])) {
            $id = $data["id"];
            $number = $data["number"];

            $model_articles_type = ArticlesType::find($id);
            if ($model_articles_type) {

                $model_user = $this->checkMember();
                if ($model_user) {
                    $array_orders = $this->changeNumberProductOrderForMember($model_user, $model_articles_type, $number);
                } else {
                    $array_orders = $this->changeNumberProductOrderForGuest($model_articles_type, $number);
                }

                $obj_shopping_cart = new UserShoppingCart();
                $data_product = $array_orders;
                $obj_shopping_cart->setSession($data_product);
                $subTotal = Session::get('sub_total');
                $quantityItem = Session::get('quantity_item');

                return view('articles::append.addToCart', compact('data_product', 'subTotal', 'quantityItem'));
            }
        }

        return redirect()->route('frontend.articles.index');
    }

    //Action: Click vào giở hàng trên header
    public function viewCartModal(Request $request) {
        if (isset($request)) {
            $data_product = Session::get('array_orders', []);
            $subTotal = Session::get('sub_total');
            $quantityItem = Session::get('quantity_item');

            return view('articles::append.addToCart', compact('data_product', 'subTotal', 'quantityItem'));
        }
    }

    //Action: Xóa rỗng giỏ hàng
    public function emptyCart(Request $request) {
        if (isset($request)) {

            $model_user = $this->checkMember();
            if ($model_user) {
                $obj_shopping_cart = new UserShoppingCart();
                $obj_shopping_cart->emptyShoppingCart($model_user);
            }

            $obj_shopping_cart = new UserShoppingCart();
            $obj_shopping_cart->emptySession();


            return redirect()->route('frontend.articles.index');
        }
    }

}
