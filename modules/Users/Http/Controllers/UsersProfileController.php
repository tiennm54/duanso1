<?php

namespace Modules\Users\Http\Controllers;

use App\Models\UserProfiles;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Modules\Users\Http\Requests\ChangePasswordRequest;
use Pingpong\Modules\Routing\Controller;
use DougSisk\CountryState\CountryState;
use DB;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;

class UsersProfileController extends CheckMemberController  {


    public function __construct(){
        $this->middleware("member");
    }

    public function seoMyAccount($model_seo){
        $url_page = URL::route('users.getMyAccount');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    //Hiển thị trang quản lý của khách hàng
    public function getMyAccount(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoMyAccount($model_seo);
        }
        $model = $this->checkMember();
        if ($model) {
            return view('users::user.my_account');
        }
        return redirect()->route('users.getLogin');
    }

    public function seoEditProfile($model_seo){
        $url_page = URL::route('users.getEditProfile');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    ///CẦN LÀM THÊM MIDDWARE
    public function getEditProfile(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoEditProfile($model_seo);
        }
        $model = $this->checkMember();
        if ($model){
            $country = "US";
            if ($model->profiles){
                if ($model->profiles->country != ""){
                    $country = $model->profiles->country;
                }
            }
            $countryState = new CountryState();
            $countries = $countryState->getCountries();
            $countryState = new CountryState();
            $states = $countryState->getStates($country);

            return view('users::profile.edit_profile', compact('model','countries','states'));
        }else{
            return redirect()->route('users.getLogin');
        }

    }

    public function postEditProfile(Request $request){
        if (isset($request)){
            $data = $request->all();

            $model = $this->checkMember();

            if ($model){
                DB::beginTransaction();

                UserProfiles::where("users_id","=",$model->id)->delete();

                $model_profile = new UserProfiles();
                $model_profile->users_id = $model->id;
                $model_profile->users_roles_id = $model->roles_id;
                $model_profile->company = $data["company"];
                $model_profile->telephone = $data["telephone"];
                $model_profile->fax = $data["fax"];
                $model_profile->street_address_01 = $data["street_address_01"];
                $model_profile->street_address_02 = $data["street_address_02"];
                $model_profile->city = $data["city"];
                $model_profile->zip_code = $data["zip_code"];
                $model_profile->state_province = $data["state_province"];
                $model_profile->country = $data["country"];
                $model_profile->save();


                $model->first_name = $data["first_name"];
                $model->last_name = $data["last_name"];
                $model->full_name = $data["first_name"]." ".$data["last_name"];
                $model->save();

                DB::commit();

                $country = "US";
                if ($model->profiles){
                    if ($model->profiles->country != ""){
                        $country = $model->profiles->country;
                    }
                }

                $countryState = new CountryState();
                $countries = $countryState->getCountries();
                $countryState = new CountryState();
                $states = $countryState->getStates($country);

                $request->session()->flash('alert-success', 'Success: Your account has been successfully updated.');
                return view('users::profile.edit_profile', compact('model','countries','states'));
            }else{
                return redirect()->route('users.getLogin');
            }
        }
    }

    public function seoChangePassword($model_seo){
        $url_page = URL::route('users.getChangePassword');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    //Thay đổi password
    public function getChangePassword(){
        $model_seo = Seo::where("type","=","index")->first();
        if ($model_seo) {
            $this->seoChangePassword($model_seo);
        }
        $model = $this->checkMember();
        if ($model){
            return view('users::profile.change-password');
        }else{
            return redirect()->route('users.getLogin');
        }
    }

    public function postChangePassword(ChangePasswordRequest $request){
        if (isset($request)){
            $data = $request->all();
            $model = $this->checkMember();
            if ($model){
                $current_password = $data["current_password"];
                $new_password = $data["new_password"];

                if (Hash::check($current_password, $model->password)){
                    $model->password = Hash::make($new_password);
                    $model->save();

                    $request->session()->flash('alert-success', ' Success: Your password has been successfully updated.');
                    return redirect()->route('users.getMyAccount');

                }else{
                    $request->session()->flash('alert-warning', 'Warning: Please retype your current password!');
                    return redirect()->route('users.getChangePassword');
                }
            }
        }
        return redirect()->route('users.getLogin');
    }
}