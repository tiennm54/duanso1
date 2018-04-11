<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class FeedBackRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required|min:20',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

}
