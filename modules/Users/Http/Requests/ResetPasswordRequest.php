<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class ResetPasswordRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ];
    }

}
