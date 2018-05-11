<?php
namespace Modules\Blog\Http\Requests;
use App\Http\Requests\Request;

class CommentRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'comment' => 'required|min:10',
            //'g-recaptcha-response' => 'required|captcha'
        ];
    }

}
