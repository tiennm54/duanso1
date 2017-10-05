<?php
namespace Modules\Admin\Http\Requests;
use App\Http\Requests\Request;

class CategoryFaqRequest extends Request {

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'	=> 'required|unique:category_faq,title|max:70',
            'description'	=> 'required:category_faq,description|max:160',
        ];
    }

    public function messages () {
        return [
            'title.required'	=> 'Please Enter Name',
            'title.unique'	=> 'This name already exists',
            'description.required'	=> 'Please Enter Description',
        ];
    }

}
