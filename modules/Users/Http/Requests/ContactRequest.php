<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class ContactRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'enquiry' => 'required|min:20',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }
    
    public function messages () {
        return [
            //'email.required'	=> 'Please Enter Username',
            'g-recaptcha-response.required' => 'The captcha field is required'
        ];
    }

}
