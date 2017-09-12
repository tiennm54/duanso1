<?php
namespace Modules\Users\Http\Requests;
use App\Http\Requests\Request;

class ChangePasswordRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'current_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',


        ];
    }
    public function messages () {
        return [

        ];
    }

}
