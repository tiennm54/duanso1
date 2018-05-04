<?php

namespace Modules\Config\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageManager;
use Modules\Config\Http\Requests\ImageRequest;


class ImageManagerController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function getCreate(Request $request) {
        $model = new ImageManager();
        if(isset($request->search_title) && $request->search_title != ""){
            $model = $model->where("title","LIKE", "%" . $request->search_title . "%");
        }
        $model = $model->orderBy('id', 'desc')->paginate(NUMBER_PAGE);
        return view('config::imageManager.create', compact('model'));
    }

    public function postCreate(ImageRequest $request) {
        $model = new ImageManager();
        if(isset($request->title)){
            $model->title = $request->title;
        }
        if (isset($request->image)) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/news');
                $image->move($destinationPath, $input['image_name']);
                $model->image = $input['image_name'];
                $model->save();
                $request->session()->flash('alert-success', 'Success: Tạo image thành công');
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Tạo image lỗi');
        return back();
    }

    public function delete($id, Request $request) {
        $model = ImageManager::find($id);
        if ($model) {
            if ($model->image && file_exists('images/news/' . $model->image)) {
                unlink('images/news/' . $model->image);
            }
            $model->delete();
            $request->session()->flash('alert-success', 'Success: Xóa image thành công');
            return back();
        }
        $request->session()->flash('alert-warning', 'Warning: Xóa image lỗi');
        return back();
    }

}
