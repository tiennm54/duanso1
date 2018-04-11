<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Seo;
use Log;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use DougSisk\CountryState\CountryState;
use URL;
use App\Helpers\SeoPage;


class ArticlesController extends Controller {

    public function seoIndex($model_seo){
        $url_page = URL::route('frontend.articles.index');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function index() {
        $model_seo = Seo::where("type", "=", "index")->first();
        if ($model_seo) {
            $this->seoIndex($model_seo);
        }
        $model = Articles::where("status_disable","=",0)
                ->where("status_stock","=",1)
                ->orderBy("order_count", "DESC")
                ->orderBy("view_count", "DESC")
                ->get();
        return view('articles::articles.index', compact("model"));
    }

    public function getListProduct() {
        $model_seo = Seo::where("type", "=", "index")->first();
        if ($model_seo) {
            $this->seoIndex($model_seo);
        }
        $model = Articles::where("status_disable","=",0)->orderBy("position", "ASC")->get();
        return view('articles::articles.index_list_product', compact("model"));
    }

    public function seoPricing($model){
        $url_page = URL::route('frontend.articles.pricing', ['id' => $model->id, 'url' => $model->url_title . '.html']);
        $image_page = url('images/' . $model->image);
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    //Lựa chọn sản phẩm cần mua
    public function pricing($id = 0) {
        $model = Articles::find($id);
        if ($model != null) {
            $this->seoPricing($model);
            $model->saveViewCount();
            $model_type = ArticlesType::where("articles_id", "=", $id)->orderBy("price_order", "ASC")->get();
            $model_all_product = Articles::where("status_disable","=",0)->get();
            if (count($model_type) != 0) {
                foreach ($model_type as &$product) {
                    $product["image"] = $model->image;
                }
                return view('articles::articles.pricing', compact("model", "model_type", "model_all_product"));
            }
        }
        return redirect()->route('frontend.articles.index');
    }

    public function getStateCountry(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            if (isset($data["country_id"])) {
                $countryState = new CountryState();
                $states = $countryState->getStates($data["country_id"]);
                return $states;
            }
        }
    }

    public function getSearch(Request $request) {
        $data = $request->all();
        if (isset($data["keyword"]) && $data["keyword"] != "") {
            $keyword = $data["keyword"];
            if ($keyword != "") {
                $keyword = preg_replace('/[^a-zA-Z0-9 ]/', '', $keyword);
                $model = Articles::where("title", "LIKE", "%" . $keyword . "%")->orderBy("position", "ASC")->get();
                if(count($model) == 0){
                    $keyword = str_replace(' ', '', $keyword);
                }
                $model = Articles::where("title", "LIKE", "%" . $keyword . "%")->orderBy("position", "ASC")->get();
                return view('articles::articles.index', compact("model"));
            }
        }
        return redirect()->route('frontend.articles.index');
    }

}
