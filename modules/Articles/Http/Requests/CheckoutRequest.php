<?php
namespace Modules\Articles\Http\Requests;
use App\Http\Requests\Request;

class CheckoutRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ];
    }

}
