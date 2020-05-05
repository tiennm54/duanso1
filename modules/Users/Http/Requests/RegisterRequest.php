<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class RegisterRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required:users,first_name',
            'last_name' => 'required:users,last_name',
            'email'	=> 'required|email|unique:users,email,'.$this->id,
            'password' => 'required:users,password|min:5',
            'confirm_password' => 'required|same:password',
            'sponsor' => 'email',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
    public function messages () {
        return [
            //'txt_username.required'	=> 'Please Enter Username',
            'g-recaptcha-response.required' => 'The captcha field is required'
        ];
    }

}
