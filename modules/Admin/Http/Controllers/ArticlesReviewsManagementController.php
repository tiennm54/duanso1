<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Articles;
use App\Models\ArticlesReviews;

/**
 * Description of ArticlesReviewsManagementController
 *
 * @author minht
 */
class ArticlesReviewsManagementController extends Controller {

    public function __construct() {
        $this->middleware("role");
    }

    public function insertDb(Request $request) {
        $model_articles = Articles::where("status_disable", "=", 0)
                        ->where("status_stock", "=", 1)->get();
        $count = 0;
        foreach ($model_articles as $item) {
            $check = ArticlesReviews::where("articles_id", "=", $item->id)->first();
            if ($check == null) {
                $arr = explode(".", $item->title);
                $product_name = $arr[0];
                $seo_title = $item->title . " Reviews | " . $item->title . " Premium Key Paypal Reseller.";
                $seo_des = "Do you trust " . $item->title . "? Tell us your reviews about " . $item->title . ". " . $item->title . " official reseller always listen to feedback from you. Buypremiumkey.com.";
                $seo_keyword = "Reviews ". $product_name . " premium key,  ". 
                        "Reviews ". $product_name . " reseller, ".
                        "Reviews ". $product_name . " paypal, ".
                        "Reviews ". $product_name . " voucher, ".
                        "Reviews ". $product_name . " account, ".
                        "Reviews ". $product_name . " counpon code, buypremiumkey reseller";

                $model = new ArticlesReviews();
                $model->articles_id = $item->id;
                $model->title = $item->title;
                $model->url_title = str_slug("reviews " . $product_name . " premium key", '-');
                $model->seo_title = $seo_title;
                $model->seo_description = $seo_des;
                $model->seo_keyword = $seo_keyword;
                $model->save();
                $count++;
            }
        }
        $request->session()->flash('alert-success', 'Success: Update Completed ('. $count . ") product reivews");
        return back();
    }

    public function index(Request $request) {
        $model = new ArticlesReviews();
        if (isset($request->title) && $request->title != "") {
            $model = $model->where("title", "LIKE", "%" . $request->title . "%");
        }
        $model = $model->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return view('admin::articlesReviews.index', compact('model'));
    }

    public function getEdit($id) {
        $model = ArticlesReviews::find($id);
        if ($model != null) {
            return view('admin::articlesReviews.edit', compact('model'));
        }
    }

    public function postEdit($id, Request $request) {
        if (isset($request)) {
            $data = $request->all();
            $model = ArticlesReviews::find($id);
            if ($model != null) {
                $model->title = $data["title"];
                $model->description = $data["description"];
                $model->seo_title = $data["seo_title"];
                $model->seo_description = $data["seo_description"];
                $model->seo_keyword = $data["seo_keyword"];
                $model->save();
                $request->session()->flash('alert-success', 'Success: Update Completed!');
                return back();
            }
        }
        $request->session()->flash('alert-warning', 'Warning: Update Error!');
        return back();
    }

}
