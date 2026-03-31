<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\Faq;
use App\Models\News;
use App\Models\Category;
use App\Models\CategoryFaq;
use App\Models\BlackListIP;
use App\Models\ArticlesReviews;
use App\Models\Reviews;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use DougSisk\CountryState\CountryState;
use App\Helpers\SeoPage;
use Illuminate\Support\Facades\Session;
use DB;
use Log;

class ArticlesController extends Controller {

    public function __construct() {
        $this->middleware("banListIP");
    }

    public function index() {
        SeoPage::seoPage($this);

        $modelIP = new BlackListIP();
        $user_ip = $modelIP->getUserIpAddr();
        $infoIP = $modelIP->getInfoIP($user_ip);

        $user_country = "";
        $paypal_watching = false;
        $check_proxy_vpn = false;
        
        if ($infoIP['status'] == 'success') {
            $user_country = $infoIP['countryCode'];
            $check_isp = strpos(strtolower($infoIP['isp']), 'paypal');
            $check_proxy = $infoIP['proxy'];
            $check_hosting = $infoIP['hosting'];
            if ($check_isp !== false || $check_proxy === true || $check_hosting === true) {
                if ($check_isp !== false) {// Kiem tra xem phai paypal hay ko?
                    $paypal_watching = true;
                }
            }
            if ($check_proxy === true || $check_hosting === true) {// kiem tra proxy vpn
                $check_proxy_vpn = true;
            }
        }
        
        Session::set('user_ip', $user_ip);
        Session::set('user_country', $user_country);
        Session::set('paypal_watching', $paypal_watching);
        Session::set('check_proxy_vpn', $check_proxy_vpn);
        
        if ($paypal_watching == true) {
            return view('errors.maintained');
        }

        $model = Articles::where("status_disable", "=", 0)
                ->where("status_stock", "=", 1)
                ->orderBy("order_count", "DESC")
                ->orderBy("view_count", "DESC")
                ->get();

        $model_reviews = Reviews::where("review_rate", ">=", 4)->orderBy("id", "DESC")->limit(6)->get();

        return view('articles::articles.index', compact("model", "model_reviews","user_country", "check_proxy_vpn"));
    }

    public function getListProduct() {
        SeoPage::seoPage($this);
        $model = Articles::where("status_disable", "=", 0)->where("status_stock", "=", 1)->orderBy("title", "ASC")->get();
        $model_reviews = Reviews::where("review_rate", ">=", 4)->orderBy("id", "DESC")->limit(6)->get();
        return view('articles::articles.index', compact("model","model_reviews"));
    }

    public function seoPricing($model) {
        $url_page = $model->getUrlPricing();
        if ($model->image_seo) {
            $image_page = url('images/productSeo/' . $model->image_seo);
        } else {
            $image_page = url('images/' . $model->image);
        }
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    //Lựa chọn sản phẩm cần mua
    public function pricing($id = 0) {
        $model = Articles::find($id);
        if ($model != null) {
            $this->seoPricing($model);
            $model->saveViewCount();
            $model_type = ArticlesType::where("articles_id", "=", $id)
                    ->where("status_show", "!=", "hide")
                    ->orderBy('status_stock', 'DESC')
                    ->orderBy("price_order", "ASC")
                    ->get();
            $model_all_product = Articles::where("status_disable", "=", 0)->get();

            //model huong dan activate cho nguoi dung
            $model_active = DB::table('faq')
                            ->join('category_faq', 'faq.category_faq_id', '=', 'category_faq.id')
                            ->select('faq.id', 'category_faq.code')
                            ->where('category_faq.code', "=", "APK")->where("product_id", "=", $model->id)->first();

            if ($model_active) {
                $model_faq = Faq::find($model_active->id);
            }

            $model_reviews = ArticlesReviews::where("articles_id", $model->id)->first();
            if (count($model_type) != 0) {
                return view('articles::articles.pricing', compact(
                                "model", "model_type", "model_all_product", "model_faq", "model_reviews"
                ));
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
                            //->where("status_disable", "=", 0)
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

                    $model_reviews = Reviews::where("review_rate", ">=", 4)->orderBy("id", "DESC")->limit(6)->get();

                    return view('articles::articles.index', compact("model", "model_reviews"));
                }
            }
        }
        return redirect()->route('frontend.articles.index');
    }

}
