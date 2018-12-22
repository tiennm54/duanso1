<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;

class UserEditRequest extends Request {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'email' => 'required|unique:users,email,' . $this->id,
        ];
    }

}
