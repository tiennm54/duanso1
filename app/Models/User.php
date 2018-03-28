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
use Illuminate\Support\Facades\Session;
use Log;

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
        $this->first_name = $data["first_name"];
        $this->last_name = $data["last_name"];
        $this->full_name = $data["first_name"] . " " . $data["last_name"];
        $this->email = $data["email"];
        $this->password = Hash::make($password);
        $this->roles_id = 2; // memeber
        $this->save();

        $model_shipping_address = new UserShippingAddress();
        $model_shipping_address->user_id = $this->id;
        $model_shipping_address->email = $this->email;
        $model_shipping_address->status = "default";
        $model_shipping_address->save();

        //Add profile
        $model_profile = new UserProfiles();
        $model_profile->users_id = $this->id;
        $model_profile->users_roles_id = $this->roles_id;
        $model_profile->save();

        $result = array(
            'user_id' => $this->id,
            'password' => $password,
            'email' => $this->email
        );
        return $result;
    }

    //Lấy danh sách số tiền được thưởng
    public function getModelBonus() {
        $model_bonus = $total_bonus_money = BonusHistory::where('user_buy_id', '=', $this->id)
                        ->where("bonus_type", "Buyer")
                        ->orWhere(function ($query) {
                            $query->where('user_sponser_id', $this->id)
                            ->where('bonus_type', 'Sponser');
                        })->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return $model_bonus;
    }

    //Lấy danh sách số tiền đã chi tiêu
    public function getModelSpending() {
        $model_spending = BonusPaymentHistory::where("user_id", $this->id)
                        ->where(function ($query) {
                            $query->where("status", "=", "completed")
                            ->orWhere('status', '=', 'pending');
                        })->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return $model_spending;
    }

    //Lấy tiền được thưởng
    public function getMoneyBonus() {
        $total_bonus_money = BonusHistory::where('user_buy_id', '=', $this->id)
                        ->where("bonus_type", "Buyer")
                        ->orWhere(function ($query) {
                            $query->where('user_sponser_id', $this->id)
                            ->where('bonus_type', 'Sponser');
                        })->sum("bonus");

        return $total_bonus_money;
    }

    //Lấy tiền chi tiêu
    public function getSpendingMoney() {
        $total_bonus_paid = BonusPaymentHistory::where("user_id", "=", $this->id)
                ->where(function ($query) {
                    $query->where("status", "=", "completed")
                    ->orWhere('status', '=', 'pending');
                })
                ->sum("total_payment");
        return $total_bonus_paid;
    }

    public function getSpendingMoneyCompleted() {
        $total_bonus_completed = BonusPaymentHistory::where("user_id", "=", $this->id)
                ->where("status", "=", "completed")
                ->sum("total_payment");
        return $total_bonus_completed;
    }

    public function getMoneyForUser() {
        $total_bonus_money = $this->getMoneyBonus();
        $total_bonus_paid = $this->getSpendingMoney();
        $total_money = $total_bonus_money - $total_bonus_paid;
        $total_money = number_format($total_money, 2);
        return $total_money;
    }

    public function getMoneyAccountCurrent() {
        $money = $this->user_money;
        $money = number_format($money, 2);
        return $money;
    }

    public function updateMoneyForUser($total_money) {
        $this->user_money = $total_money;
        $this->save();
    }

    public function saveLockStatus() {
        if ($this->status_lock != 1) {
            $this->status_lock = 1; // lock account
            $this->save();
        }
    }

    public function saveUnLock() {
        if ($this->status_lock != 0) {
            $this->status_lock = 0; // lock account
            $this->save();
        }
    }

    public function updateSessionMoney($money) {
        Session::set('user_money', $money);
    }
    
    
    public function countTotalUser(){
        $count = User::count();
        return $count;
    }
    
    public function getModelUserLock(){
        $model = User::where("status_lock","=",1)->get();
        return $model;
    }

}
