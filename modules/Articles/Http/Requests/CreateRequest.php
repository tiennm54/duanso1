<?php
namespace Modules\Articles\Http\Requests;
use App\Http\Requests\Request;

class CreateRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'txt_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //'txt_name'	=> 'required|unique:articles,name',
        ];
    }
    public function messages () {
        return [
            'txt_image.required'	=> 'B?n ch?a ch?n hình ?nh',
            'txt_name.required'	=> 'B?n ch?a ch?n tên',
        ];
    }

}
