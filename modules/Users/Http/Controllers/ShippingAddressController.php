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
use Modules\Users\Http\Requests\EmailRequest;
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
use App\Helpers\SeoPage;

class ShippingAddressController extends CheckMemberController  {

    public function __construct(){
        $this->middleware("member");
    }

    public function seoShippingAddress($model_seo){
        $url_page = URL::route('users.shippingAddress.getShippingAddress');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function getShippingAddress(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoShippingAddress($model_seo);
        }
        $model_user = $this->checkMember();
        if ($model_user) {
            $model = UserShippingAddress::where("user_id", "=", $model_user->id)->get();
            return view('users::shipping-address.list-shipping-address', compact('model'));
        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function addShippingAddress(EmailRequest $request){
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