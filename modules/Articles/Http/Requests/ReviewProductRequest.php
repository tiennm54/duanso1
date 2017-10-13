<?php
namespace Modules\Articles\Http\Requests;
use App\Http\Requests\Request;

class ReviewProductRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'description' => 'required|min:20',
            'rating' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

}
