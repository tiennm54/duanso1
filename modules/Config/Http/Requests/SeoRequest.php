<?php
namespace Modules\Config\Http\Requests;
use App\Http\Requests\Request;

class SeoRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page_id' => 'required|unique:seo,page_id,'.$this->id,
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keyword' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

}
