<?php
namespace Modules\Admin\Http\Requests;
use App\Http\Requests\Request;

class CategoryRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'txt_name'	=> 'required|unique:category,name',
            'txt_description'	=> 'required:category,description',
        ];
    }
    public function messages () {
        return [
            'txt_name.required'	=> 'Please Enter Name',
            'txt_name.unique'	=> 'This name already exists',
            'txt_description.required'	=> 'Please Enter Description',
        ];
    }

}
