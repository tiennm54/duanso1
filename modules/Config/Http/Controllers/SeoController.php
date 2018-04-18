<?php

namespace Modules\Config\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Seo;
use Illuminate\Http\Request;
use App\Models\SeoCreatePage;
use Modules\Config\Http\Requests\SeoRequest;

class SeoController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function index() {
        $model = Seo::get();
        return view('config::seo.index', compact('model'));
    }

    public function getCreate() {
        $model_page = SeoCreatePage::orderBy('id', 'desc')->get();
        return view('config::seo.create', compact('model_page'));
    }

    public function postCreate(SeoRequest $request) {

        if (isset($request)) {

            $data = $request->all();
            $model = new Seo();
            $model->seo_title = $data["seo_title"];
            $model->seo_description = $data["seo_description"];
            $model->seo_keyword = $data["seo_keyword"];

            if (isset($data['page_id'])) {
                $model_seo_page = SeoCreatePage::find($data['page_id']);
                if ($model_seo_page != null) {
                    $model->page_id = $model_seo_page->id;
                    $model->page_code = $model_seo_page->code;
                }
            }

            if (isset($request->image)) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/feedback');
                    $image->move($destinationPath, $input['image_name']);
                    $model->image = $input['image_name'];
                }
            }

            $model->save();
            return redirect()->route('config.seo.getEdit', ["id" => $model->id]);
        }

        return back();
    }

    public function getEdit($id) {
        $model = Seo::find($id);
        $model_page = SeoCreatePage::orderBy('id', 'desc')->get();
        if ($model) {
            return view('config::seo.create', compact('model', 'model_page'));
        }
    }

    public function postEdit($id, SeoRequest $request) {
        $model = Seo::find($id);
        if ($model) {
            $data = $request->all();
            $old_image = $model->image;
            $model->seo_title = $data["seo_title"];
            $model->seo_description = $data["seo_description"];
            $model->seo_keyword = $data["seo_keyword"];
            if (isset($data['page_id'])) {
                $model_seo_page = SeoCreatePage::find($data['page_id']);
                if ($model_seo_page != null) {
                    $model->page_id = $model_seo_page->id;
                    $model->page_code = $model_seo_page->code;
                }
            }

            if (isset($request->image)) {
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $input['image_name'] = time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/seo');
                    $image->move($destinationPath, $input['image_name']);
                    $model->image = $input['image_name'];
                    if ($old_image && file_exists('images/seo/' . $old_image)) {
                        unlink('images/seo/' . $old_image);
                    }
                }
            }

            $model->save();
            return redirect()->route('config.seo.getEdit', ["id" => $model->id]);
        }
    }

    public function getDelete($id) {
        $model = Seo::find($id);
        if ($model) {
            $model->delete();
        }
        return back();
    }

}
