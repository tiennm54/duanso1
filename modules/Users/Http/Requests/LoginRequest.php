<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class LoginRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'	=> 'required|email:users,email',
            'password' => 'required:users,password',
        ];
    }
    public function messages () {
        return [
            //'email.required'	=> 'Please Enter Username',
            //'password.required'	=> 'Please Enter Password',
        ];
    }

}
