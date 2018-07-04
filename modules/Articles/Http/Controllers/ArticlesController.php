<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Faq;
use App\Models\News;
use App\Models\Category;
use App\Models\CategoryFaq;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use DougSisk\CountryState\CountryState;
use App\Helpers\SeoPage;
use DB;
use Log;

class ArticlesController extends Controller {

    public function index() {
        SeoPage::seoPage($this);
        $model = Articles::where("status_disable", "=", 0)
                ->where("status_stock", "=", 1)
                ->orderBy("order_count", "DESC")
                ->orderBy("view_count", "DESC")
                ->get();
        return view('articles::articles.index', compact("model"));
    }

    public function getListProduct() {
        SeoPage::seoPage($this);
        $model = Articles::where("status_disable", "=", 0)->where("status_stock", "=", 1)->orderBy("id", "DESC")->get();
        return view('articles::articles.index_list_product', compact("model"));
    }

    public function seoPricing($model) {
        $url_page = $model->getUrlPricing();
        $image_page = url('images/' . $model->image);
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    //Lựa chọn sản phẩm cần mua
    public function pricing($id = 0) {
        $model = Articles::find($id);
        if ($model != null) {
            $this->seoPricing($model);
            $model->saveViewCount();
            $model_type = ArticlesType::where("articles_id", "=", $id)->where("status_show","!=","hide")
                    ->orderBy('status_stock', 'DESC')->orderBy("price_order", "ASC")->get();
            $model_all_product = Articles::where("status_disable", "=", 0)->get();

            $model_active = DB::table('faq')
                            ->join('category_faq', 'faq.category_faq_id', '=', 'category_faq.id')
                            ->select('faq.id', 'category_faq.code')
                            ->where('category_faq.code', "=", "APK")->where("product_id", "=", $model->id)->first();

            if ($model_active) {
                $model_faq = Faq::find($model_active->id);
            }

            if (count($model_type) != 0) {
                foreach ($model_type as &$product) {
                    $product["image"] = $model->image;
                }
                return view('articles::articles.pricing', compact("model", "model_type", "model_all_product", "model_faq"));
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
        if (isset($data["keyword"]) && $data["keyword"] != "" && isset($data["type"]) && $data["type"] != "") {
            $keyword = $data["keyword"];
            $type = $data["type"];
            if ($keyword != "" && $type != "") {
                $keyword = preg_replace('/[^a-zA-Z0-9 ]/', '', $keyword);

                if ($type == "news") {
                    $model_cate = Category::orderBy("id", "ASC")->get();
                    $model = News::where("title", "LIKE", "%" . $keyword . "%")->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
                    return view('blog::news.index', compact("model", "model_cate"));
                }
                if ($type == "faq") {
                    $model_cate = CategoryFaq::orderBy("id", "ASC")->get();
                    $model = Faq::where("title", "LIKE", "%" . $keyword . "%")->orderBy("id", "ASC")->paginate(NUMBER_PAGE);
                    return view('blog::faq.index', compact("model", "model_cate"));
                }

                if ($type == "product") {
                    $model = Articles::where("title", "LIKE", "%" . $keyword . "%")
                            ->where("status_disable", "=", 0)
                            ->where("status_stock", "=", 1)
                            ->orderBy("order_count", "DESC")
                            ->orderBy("view_count", "DESC")
                            ->get();
                    
                    if (count($model) == 0) {
                        $keyword = str_replace(' ', '', $keyword);
                        $model = Articles::where("title", "LIKE", "%" . $keyword . "%")
                                ->where("status_disable", "=", 0)
                                ->where("status_stock", "=", 1)
                                ->orderBy("order_count", "DESC")
                                ->orderBy("view_count", "DESC")
                                ->get();
                    }

                    return view('articles::articles.index', compact("model"));
                }
            }
        }
        return redirect()->route('frontend.articles.index');
    }

}
