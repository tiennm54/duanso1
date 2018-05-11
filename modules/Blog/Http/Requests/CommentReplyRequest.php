<?php
namespace Modules\Blog\Http\Requests;
use App\Http\Requests\Request;

class CommentReplyRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email_reply' => 'required|email',
            'comment_reply' => 'required|min:10',
            'g-recaptcha-response' => 'required|captcha'
        ];
    }

}
