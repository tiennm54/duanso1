<?php
namespace Modules\Config\Http\Requests;
use App\Http\Requests\Request;

class SeoPageRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:seo_create_page,name,'.$this->id,
            'code' => 'required|unique:seo_create_page,code,'.$this->id,
        ];
    }

}
