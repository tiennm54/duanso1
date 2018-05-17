<?php

namespace Modules\Blog\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Helpers\SeoPage;
use App\Models\Faq;
use App\Models\CategoryFaq;

class FaqController extends Controller {

    public function seoFaqCate($model) {
        $url_page = $model->getUrl();
        $image_page = "";
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    public function seoFaqView($model) {
        $url_page = $model->getUrl();
        $image_page = "";
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    public function index() {
        SeoPage::seoPage($this);
        $model_cate = CategoryFaq::orderBy("id", "ASC")->get();
        $model = Faq::orderBy("id", "ASC")->paginate(NUMBER_PAGE);
        return view('blog::faq.index', compact("model", "model_cate"));
    }

    public function view($id) {
        $model_cate = CategoryFaq::orderBy("id", "ASC")->get();
        $model = Faq::find($id);
        if ($model) {
            $this->seoFaqView($model);
            $model->view = $model->view + 1;
            $model->save();
            return view('blog::faq.view', compact("model", "model_cate"));
        }
        return redirect()->route('frontend.news.index');
    }

    public function cateFaq($id) {
        $cate = CategoryFaq::find($id);
        if ($cate) {
            $model = Faq::where("category_faq_id", "=", $id)->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
            $model_cate = CategoryFaq::orderBy("id", "ASC")->get();
            $this->seoFaqCate($cate);
            return view('blog::faq.index', compact("model", "model_cate", "cate"));
        }
        return redirect()->route('frontend.faq.index');
    }

}
