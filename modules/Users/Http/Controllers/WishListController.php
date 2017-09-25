<?php

namespace Modules\Users\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\UserWishList;
use Illuminate\Http\Request;
use Hash;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;

class WishListController extends CheckMemberController  {

    public function addWishlist(Request $request){
        if (isset($request)){
            $data = $request->all();
            if (isset($data["product_id"])){
                $product_id = $data["product_id"];
                $model_user = $this->checkMember();
                $model_product = ArticlesType::find($product_id);
                if ($model_product) {
                    if ($model_user) {
                        $check = UserWishList::where("articles_type_id", "=", $product_id)->where("user_id", "=", $model_user->id)->first();
                        if ($check == null) {
                            $model = new UserWishList();
                            $model->user_id = $model_user->id;
                            $model->articles_type_id = $model_product->id;
                            $model->save();
                        }
                        $string = '<i class="fa fa-check-circle"></i>' .
                            ' Success: You have added' .
                            ' <a href="' . URL::route('frontend.articles.view', $model_product->id) . '">' . $model_product->title . '</a>' .
                            ' to your ' .
                            ' <a href="' . URL::route('users.getWishList') . '">wish list</a>!';

                        $request->session()->flash('alert-success', $string);
                        return 1;

                    } else {

                        $string = '<i class="fa fa-check-circle"></i>' .
                            ' You must'.
                            ' <a href="'.URL::route('users.getLogin').'">login</a> or'.
                            ' <a href="'.URL::route('users.getRegister').'">create an account</a> to save' .
                            ' <a href="' . URL::route('frontend.articles.view', $model_product->id) . '">' . $model_product->title . '</a>' .
                            ' to your ' .
                            ' <a href="' . URL::route('users.getWishList') . '">wish list</a>!';

                        $request->session()->flash('alert-warning', $string);
                        return 0;
                    }
                }
            }
        }
    }

    public function seoWishList($model_seo){
        $url_page = URL::route('users.getWishList');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function getWishList(){

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            $this->seoWishList($model_seo);
        }

        $model_user = $this->checkMember();
        if ($model_user) {
            $model = UserWishList::where("user_id","=",$model_user->id)->get();
            return view('users::wish-list.wish_list', compact('model'));
        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function deleteWishList($id, Request $request){
        $model_user = $this->checkMember();
        if ($model_user) {
            $model = UserWishList::where("user_id","=",$model_user->id)->where("articles_type_id","=",$id)->get();

            if (count($model) > 0){
                UserWishList::where("user_id","=",$model_user->id)->where("articles_type_id","=",$id)->delete();
                $request->session()->flash('alert-success', ' Success: You have modified your wish list!');
                return redirect()->route('users.getWishList');
            }else{
                $request->session()->flash('alert-warning', 'Warning: Delete Wish List Error!');
                return redirect()->route('users.getWishList');
            }

        }else{
            return redirect()->route('users.getLogin');
        }
    }

}