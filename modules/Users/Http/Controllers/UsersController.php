<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\SendEmailController;
use App\Models\UserOrders;
use App\Models\UserShippingAddress;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Modules\Users\Http\Requests\LoginRequest;
use Modules\Users\Http\Requests\RegisterRequest;
use Modules\Users\Http\Requests\ResetPasswordRequest;
use DougSisk\CountryState\CountryState;
use App\Models\UserShoppingCart;
use DB;
use Crisu83\ShortId\ShortId;
use Illuminate\Support\Facades\Mail;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;
use Illuminate\Support\Facades\Session;
use App\Helpers\SeoPage;

class UsersController extends CheckMemberController {

    public function getInfoUser($model_user){
        Session::set('user_email_login', $model_user->email);
        $obj_shopping_cart = new  UserShoppingCart();
        $array_orders =  $obj_shopping_cart->getShoppingOrder($model_user);
        $obj_shopping_cart->setSession($array_orders);
    }

    public function seoLogin($model_seo){
        $url_page = URL::route('users.getLogin');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

	public function getLogin(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoLogin($model_seo);
        }
		return view('users::user.login');
	}

	public function postLogin(LoginRequest $request){
			if(isset($request)){
				$data = $request->all();
				$userdata = array(
					'email' => $data["email"],
					'password' => $data["password"]
				);

				if(Auth::attempt($userdata)){
					$user = User::find(Auth::user()->id);
					if($user->role) {
						switch($user->role->alias){
							case "admin" :
                                Session::set('user_email_login', "Admin");
								return redirect()->route('articles.index');
							case "member" :

                                $this->getInfoUser($user);

                                //return redirect()->intended('users.getMyAccount');
                                return redirect()->route('users.getMyAccount');


                            default:
                                return view('users::user.login');
						}
					}
				}else{
                    return view('users::user.login');
                }
			}
	}

    public function seoRegister($model_seo){
        $url_page = URL::route('users.getRegister');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

	public function getRegister(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoRegister($model_seo);
        }
        return view('users::user.register');
    }

    public function postRegister(RegisterRequest $request){
        if (isset($request)){
            DB::beginTransaction();
            $data = $request->all();

            $check_user_exits = User::where("email","=",trim($data["email"]))->count();
            if ($check_user_exits == 0) {

                $model = new User();
                $model->first_name = $data["first_name"];
                $model->last_name = $data["last_name"];
                $model->full_name = $data["first_name"]." ".$data["last_name"];
                $model->email = $data["email"];
                $model->password = Hash::make($data["password"]);
                $model->roles_id = 2; // memeber
                $model->save();


                $model_shipping_address = new UserShippingAddress();
                $model_shipping_address->user_id = $model->id;
                $model_shipping_address->email = $model->email;
                $model_shipping_address->status = "default";
                $model_shipping_address->save();

                Auth::loginUsingId($model->id);

                DB::commit();

                Session::set('user_email_login', $model->email);

                return redirect()->route('users.getRegisterSuccess');

            }else{
                $string = '<i class="fa fa-check-circle"></i>' .
                    ' Warning: There is already an account with this email address. If you are sure that it is your email address,' .
                    ' <a href="' . URL::route('users.getForgotten') . '">' . 'click here' . '</a>' .
                    ' to get your password and access your account. ';

                $request->session()->flash('alert-warning', $string);
                return redirect()->route('users.getRegister');
            }

        }

        $request->session()->flash('alert-warning', 'Warning: Register error!');
        return redirect()->route('users.getRegister');
    }


    public function seoRegisterSuccess($model_seo){
        $url_page = URL::route('users.getRegisterSuccess');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function getRegisterSuccess(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoRegisterSuccess($model_seo);
        }
        $model = $this->checkMember();
        if ($model) {
            return view('users::user.register-success');
        }else{
            return redirect()->route('users.getRegister');
        }
    }

    public function seoAfterLogout($model_seo){
        $url_page = URL::route('users.afterLogout');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function afterLogout(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoAfterLogout($model_seo);
        }
        return view('users::user.logout');
    }

    public function getLogout(){
        Auth::logout();
        Session::flush();
        return redirect()->route('users.afterLogout');
    }

    public function seoForgotten($model_seo){
        $url_page = URL::route('users.getForgotten');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }
    //Hiển thị trang khi người dùng quên mật khẩu
    public function getForgotten(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoForgotten($model_seo);
        }
        return view('users::user.forgotten');
    }

    public function postForgotten(Request $request){
        if (isset($request)){
            $data = $request->all();
            $email = trim($data["email"]);
            $model = User::where("email","=", $email)->first();
            if ($model){

                $obj_key = ShortId::create(array("length" => 30));
                $key = $obj_key->generate();
                $model->key_forgotten = $key;
                $model->save();

                Mail::send('users::email.email-forgotten', ['user' => $model], function ($m) use ($model) {
                    $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
                    $m->to($model->email, $model->name)->subject(SUBJECT_FORGOT);
                });

                $request->session()->flash('alert-success', ' Success: If there is an account associated with '. $model->email .' you will receive an email with a link to reset your password.!');
                return redirect()->route('users.getLogin');

            }else{
                $request->session()->flash('alert-danger', ' Warning: The E-Mail Address was not found in our records, please try again!');
                return redirect()->route('users.getForgotten');
            }
        }
    }

    public function seoResetPassword($model_seo){
        $url_page = URL::route('users.getForgotten');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function getResetPassword($email, $key_forgotten, Request $request){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoResetPassword($model_seo);
        }

        $model = User::where("email","=",$email)->where("key_forgotten","=",trim($key_forgotten))->first();
        if ($model){
            return view('users::user.reset-password', compact('email','key_forgotten'));
        }else{
            $request->session()->flash('alert-danger', ' Warning: Url not found!');
            return redirect()->route('users.getForgotten');
        }
    }

    public function postResetPassword($email, $key_forgotten, ResetPasswordRequest $request){
        $model = User::where("email","=",$email)->where("key_forgotten","=",trim($key_forgotten))->first();

        if ($model){
            $data = $request->all();
            if (isset($data["new_password"])){
                $model->password = Hash::make($data["new_password"]);
                $model->key_forgotten = "";
                $model->save();
                $request->session()->flash('alert-success', ' Success: Reset password Completed!');
                return redirect()->route('users.getLogin');
            }

        }else{
            $request->session()->flash('alert-danger', ' Warning: Url not found!');
            return redirect()->route('users.getForgotten');
        }
    }


    public function getStateCountry(Request $request){
        if(isset($request)){
            $data = $request->all();
            if(isset($data["country_id"])){
                $countryState = new CountryState();
                $states = $countryState->getStates($data["country_id"]);
                return $states;
            }
        }
    }


    public function viewEmail(){

        $model_orders = UserOrders::first();
        $list_product = array(
             array(
                 "title" => "File Bom",
                 "key" => "aaaaaaaaaaaaaaaaaaaaaaaaaa",
                 "price_order" => 20
             ),
            array(
                "title" => "File Bom",
                "key" => "aaaaaaaaaaaaaaaaaaaaaaaaaa",
                "price_order" => 20
            )
        );
        return view("admin::userOrders.email-sent-product", compact('list_product','model_orders'));

    }


}