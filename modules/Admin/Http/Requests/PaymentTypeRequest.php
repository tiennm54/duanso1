<?php
namespace Modules\Admin\Http\Requests;
use App\Http\Requests\Request;

class PaymentTypeRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'txt_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'txt_title'	=> 'required|unique:payments_type,title,'.$this->id,
            'txt_position'	=> 'required:payments_type,position',
            'txt_fees'	=> 'required:payments_type,fees',
        ];
    }
    public function messages () {
        return [
            'txt_name.required'	=> 'Hãy điền tên cho loại thanh toán !',
            'txt_name.unique'	=> 'Loại thanh toán này đã tồn tại !',

            'txt_position.required'	=> 'Hãy điền số thứ tự hiển thị !',
        ];
    }

}
