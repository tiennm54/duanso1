<?php
namespace Modules\Admin\Http\Requests;
use App\Http\Requests\Request;

class ArticlesRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'txt_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'txt_title'	=> 'required|unique:articles,title,'.$this->id,
            'txt_code' => 'required|unique:articles,code,'.$this->id,
            //'int_category'	=> 'required:articles,category_id',
            'int_instock' => 'required:articles,status_stock',

        ];
    }
    public function messages () {
        return [
            'txt_image.required'	=> 'Không đúng định dạng file ảnh',
            'txt_title.required'	=> 'Bạn chưa điền tiêu đề bài viết',
            'txt_code.required' => 'Bạn chưa điền mã bài viết',

            //'int_category.required' => 'Bạn chưa điền category cho bài viết',
            'int_instock.required' => 'Bạn chưa điền trạng thái trong kho',


        ];
    }

}
