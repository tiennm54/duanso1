<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Pingpong\Modules\Routing\Controller;
use Modules\Admin\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Input;

class BackendCategoryController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $model = Category::orderBy('id', 'DESC')->get();
        return view('admin::category.index', compact('model'));
    }

    public function getCreate() {
        return view('admin::category.create');
    }

    public function postCreate(CategoryRequest $request) {
        //if (isset($request)) {
        $data = Input::all();
        $model = new Category();
        $model->name = $data["txt_name"];
        $model->description = $data["txt_description"];
        $model->path_url = str_slug($data["txt_name"], '-');

        if (isset($data["txt_seo_title"])) {
            $model->seo_title = $data["txt_seo_title"];
        }

        if (isset($data["txt_seo_description"])) {
            $model->seo_description = $data["txt_seo_description"];
        }

        if (isset($data["txt_seo_keyword"])) {
            $model->seo_keyword = $data["txt_seo_keyword"];
        }

        if (isset($request->image)) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/images/news');
                $image->move($destinationPath, $input['image_name']);
                $model->image = $input['image_name'];
            }
        }

        $model->save();
        return redirect()->route('category.getEdit', ['id' => $model->id]);
        // }
    }

    public function getEdit($id) {

        $model = Category::find($id);
        if ($model) {
            return view('admin::category.create', compact('model', 'id'));
        } else {
            return view('errors.503');
        }
    }

    public function postEdit(Request $request, $id) {
        $data = $request->all();
        $model = Category::find($id);

        if ($model) {
            $old_image = $model->image;

            if (isset($data["txt_name"]) && isset($data["txt_description"])) {
                $model->name = $data["txt_name"];
                $model->description = $data["txt_description"];
            }

            if (isset($data["txt_seo_title"])) {
                $model->seo_title = $data["txt_seo_title"];
            }

            if (isset($data["txt_seo_description"])) {
                $model->seo_description = $data["txt_seo_description"];
            }

            if (isset($data["txt_seo_keyword"])) {
                $model->seo_keyword = $data["txt_seo_keyword"];
            }

            if (isset($request->image)) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/news');
                    $image->move($destinationPath, $input['image_name']);
                    $model->image = $input['image_name'];
                    if ($old_image && file_exists('images/news/' . $old_image)) {
                        unlink('images/news/' . $old_image);
                    }
                }
            }

            $model->save();
            return back();
        }
    }

    public function delete($id) {
        $model = Category::find($id);
        if ($model != null) {
            $count_news = News::where("category_id", "=", $id)->count();
            if ($count_news == 0) {
                $old_image = $model->image;
                if ($old_image && file_exists('images/news/' . $old_image)) {
                    unlink('images/news/' . $old_image);
                }
                $model->delete();
                return redirect()->route('category.index');
            } else {
                return view('errors.503');
            }
        } else {
            return view('errors.503');
        }
    }

}

?>