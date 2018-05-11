<?php
namespace Modules\Blog\Http\Requests;
use App\Http\Requests\Request;

class EditCommentRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comment_edit' => 'required|min:10',
        ];
    }

}
