<?php
namespace Modules\Admin\Http\Requests;
use App\Http\Requests\Request;

class ArticlesChildrenRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'txt_title'	=> 'required|unique:articles,title,'.$this->id,
            'txt_code' => 'required|unique:articles,code,'.$this->id,
            'decimal_price_order' => 'required:articles,price_order',
            'int_instock' => 'required:articles,status_stock',

        ];
    }
    public function messages () {
        return [
            'txt_title.required'	=> 'Bạn chưa điền tiêu đề sản phẩm',
            'txt_code.required' => 'Bạn chưa điền mã sản phẩm',
            'decimal_price_order.required' => 'Bạn chưa điền giá cho sản phẩm',
            'int_instock.required' => 'Bạn chưa điền trạng thái trong kho',
        ];
    }

}
