<?php
namespace Modules\Config\Http\Requests;
use App\Http\Requests\Request;

class ImageRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

}
