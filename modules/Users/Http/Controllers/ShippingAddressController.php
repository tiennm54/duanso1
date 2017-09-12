<?php

namespace Modules\Users\Http\Controllers;

use App\Models\UserOrders;
use App\Models\UserOrdersDetail;
use App\Models\UserShippingAddress;
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
use DB;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;

class ShippingAddressController extends CheckMemberController  {

    public function __construct(){
        $this->middleware("member");
    }


    public function getShippingAddress(){

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            SEOMeta::setTitle("Shipping address Premium Key - ".$model_seo->seo_title);
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
        if ($model_user) {
            $model = UserShippingAddress::where("user_id", "=", $model_user->id)->get();
            return view('users::shipping-address.list-shipping-address', compact('model'));
        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function addShippingAddress(Request $request){
        $model_user = $this->checkMember();
        if ($model_user) {
            if (isset($request)){
                $data = $request->all();
                $email = trim($data["email"]);
                $check_1 = UserShippingAddress::where("email","=",$email)->count();
                $check_2 = User::where("email","=",$email)->count();

                if ($check_1 == 0 && ($check_2 == 0 || $model_user->email == $email)){

                    $model = new UserShippingAddress();
                    $model->user_id = $model_user->id;
                    $model->email = $email;
                    $model->save();

                    $request->session()->flash('alert-success', 'Success: Add shipping address complete!');
                    return redirect()->route('users.shippingAddress.getShippingAddress');

                }else{
                    $request->session()->flash('alert-warning', 'Warning: There is already an account with this email address!');
                    return redirect()->route('users.shippingAddress.getShippingAddress');
                }
            }

        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function deleteShippingAddress($id, Request $request){
        $model_user = $this->checkMember();
        if ($model_user) {
            $model = UserShippingAddress::find($id);
            if ($model){
                if ($model->user_id == $model_user->id){
                    if($model->status != "default") {
                        $model->delete();
                        $request->session()->flash('alert-success', 'Success: Delete shipping address complete!');
                        return redirect()->route('users.shippingAddress.getShippingAddress');
                    }else{
                        $request->session()->flash('alert-warning', 'Warning: You can not delete this email because it is a primary key!');
                        return redirect()->route('users.shippingAddress.getShippingAddress');
                    }


                }
            }

            $request->session()->flash('alert-warning', 'Warning: Delete shipping address error!');
            return redirect()->route('users.shippingAddress.getShippingAddress');

        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function setPrimaryShippingAddress($id, Request $request){
        $model_user = $this->checkMember();
        if ($model_user) {
            $model = UserShippingAddress::find($id);
            if ($model->user_id == $model_user->id){

                UserShippingAddress::where("user_id","=",$model_user->id)->update(["status" => "add-new"]);
                $model->status = "default";
                $model->save();

                $request->session()->flash('alert-success', 'Success: Set primary shipping address complete!');
                return redirect()->route('users.shippingAddress.getShippingAddress');
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Set primary shipping address error!');
        return redirect()->route('users.shippingAddress.getShippingAddress');
    }
}