<?php

namespace App\Models;

use App\Helpers\MinhTien;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {

    use Authenticatable,
        Authorizable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function role() {
        return $this->belongsTo('App\Models\Role', 'roles_id');
    }

    public function profiles() {
        return $this->belongsTo('App\Models\UserProfiles', 'id', 'users_id');
    }

    public function shippingAddress() {
        return $this->hasMany('App\Models\UserShippingAddress', 'user_id', 'id');
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail() {
        return $this->email;
    }

    public function getRememberToken() {
        
    }

    public function setRememberToken($value) {
        
    }

    public function getRememberTokenName() {
        
    }

    public function createUser($data) {
        $password = MinhTien::createPassword();
        $model = new User();
        $model->first_name = $data["first_name"];
        $model->last_name = $data["last_name"];
        $model->full_name = $data["first_name"] . " " . $data["last_name"];
        $model->email = $data["email"];
        $model->password = Hash::make($password);
        $model->roles_id = 2; // memeber
        $model->save();

        $model_shipping_address = new UserShippingAddress();
        $model_shipping_address->user_id = $model->id;
        $model_shipping_address->email = $model->email;
        $model_shipping_address->status = "default";
        $model_shipping_address->save();

        //Add profile
        $model_profile = new UserProfiles();
        $model_profile->users_id = $model->id;
        $model_profile->users_roles_id = $model->roles_id;
        $model_profile->save();

        $result = array(
            'user_id' => $model->id,
            'password' => $password,
        );
        return $result;
    }

    public function getModelBonus() {
        $model_bonus = $total_bonus_money = BonusHistory::where('user_buy_id', '=', $this->id)
                        ->where("bonus_type", "Buyer")
                        ->orWhere(function ($query){
                            $query->where('user_sponser_id', $this->id)
                            ->where('bonus_type', 'Sponser');
                        })->paginate(NUMBER_PAGE);
        return $model_bonus;
    }
    
    public function getModelSpending(){
        $model_spending = BonusPaymentHistory::where("user_id",$this->id)->paginate(NUMBER_PAGE);
        return $model_spending;
    }

    public function getMoneyBonus() {

        $total_bonus_money = BonusHistory::where('user_buy_id', '=', $this->id)
                        ->where("bonus_type", "Buyer")
                        ->orWhere(function ($query) {
                            $query->where('user_sponser_id', $this->id)
                            ->where('bonus_type', 'Sponser');
                        })->sum("bonus");

        return $total_bonus_money;
    }

    public function getSpendingMoney() {
        $total_bonus_paid = BonusPaymentHistory::where("user_id", "=", $this->id)->where("status", "=", "completed")->sum("total_payment");
        return $total_bonus_paid;
    }

    public function getMoneyForUser() {
        //Tổng số tiền được bonus
        $total_bonus_money = $this->getMoneyBonus();
        //Tổng số tiền đã chi tiêu
        $total_bonus_paid = $this->getSpendingMoney();
        $total_money = $total_bonus_money - $total_bonus_paid;
        return $total_money;
    }

}
