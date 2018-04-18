<?php

namespace Modules\Users\Http\Controllers;

use App\Models\UserProfiles;
use Illuminate\Http\Request;
use App\Models\UserOrders;
use App\Models\UserWishList;
use App\Models\BonusHistory;
use App\Models\UserRef;
use App\Models\BonusConfig;
use App\Models\BonusPaymentHistory;
use Hash;
use Modules\Users\Http\Requests\ChangePasswordRequest;
use DougSisk\CountryState\CountryState;
use Illuminate\Support\Facades\Session;

use DB;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;

class UsersProfileController extends CheckMemberController  {


    public function __construct(){
        $this->middleware("member");
    }
    
    //Hiển thị trang quản lý của khách hàng
    public function getMyAccount(){
        $model = $this->checkMember();
        if ($model) {
            
            $total_order = UserOrders::where("users_id",$model->id)->count();
            $total_wish = UserWishList::where("user_id",$model->id)->count();
            $total_team = UserRef::where("user_sponser_id",$model->id)->count();
            $total_bonus = $model->getMoneyBonus();
            $total_spending = $model->getSpendingMoney();
            $total_money = number_format($total_bonus - $total_spending, 2);
            $link_ref = DOMAIN_SITE . "/users/register?ref=".$model->email;
            $data = array(
                "total_order" => $total_order,
                "total_wish" => $total_wish,
                "total_team" => $total_team,
                "total_bonus" => $total_bonus,
                "total_spending" => $total_spending,
                "total_money" => $total_money,
                "link_ref"=>$link_ref
            );
            $model->updateSessionMoney($total_money);
            //So tien duoc bonus bao gồm được bonus và bonus khi mua hàng
            $model_bonus = $model->getModelBonus();
            //So tien chi tieu
            $model_spending = $model->getModelSpending();
            $model_bonus_config = BonusConfig::first();
            return view('users::user.my_account', compact('data','model_bonus','model_spending','model_bonus_config','model'));
        }
        return redirect()->route('users.getLogin');
    }
    ///CẦN LÀM THÊM MIDDWARE
    public function getEditProfile(){
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

    //Thay đổi password
    public function getChangePassword(){
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