<?php

namespace Modules\Admin\Http\Requests;

use App\Http\Requests\Request;

class PaypalAccountRequest extends Request {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'phone' => 'required|unique:paypal_account,phone,' . $this->id,
            'email' => 'required|unique:paypal_account,email,' . $this->id,
            'vps_ip' => 'unique:paypal_account,vps_ip,' . $this->id,
        ];
    }

}
