<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class EmailRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

}
