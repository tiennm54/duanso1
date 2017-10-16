<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class GetKeyRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'order_no' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

}
