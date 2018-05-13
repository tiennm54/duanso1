<?php

namespace Modules\Articles\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\UserReview;
use Modules\Articles\Http\Requests\ReviewProductRequest;
use Modules\Users\Http\Controllers\CheckMemberController;
use URL;
use App\Helpers\SeoPage;

class ArticlesDetailController extends CheckMemberController {

    public function sumRateProduct($model_product) {
        $sum = 0;
        $count_user_rate = count($model_product->getReview);
        if ($count_user_rate == 0) {
            return $sum;
        } else {
            $sum = UserReview::where("articles_type_id", "=", $model_product->id)->sum("rate") / $count_user_rate;
            return $sum;
        }
    }

    public function seoView($model) {
        $url_page = $model->getUrl();
        $image_page = url('images/' . $model->getArticles->image);
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    public function view($id = 0) {

        $attributes = [
            'data-theme' => 'light',
            'data-type' => 'image',
        ];

        $model = ArticlesType::find($id);
        $model_user = $this->checkMember();
        if ($model) {
            $this->seoView($model);
            $sum_rate = $this->sumRateProduct($model);
            $model_related = ArticlesType::where("articles_id", "=", $model->articles_id)->where("id", "!=", $model->id)->get();
            $model_list_product = Articles::where("status_disable", "=", 0)->where("status_stock",1)->orderBy("title", "ASC")->get();
            return view('articles::articles.view', compact("model", "model_related", "model_user", "attributes", "sum_rate", "model_list_product"));
        }
        return redirect()->route('frontend.articles.index');
    }

    public function reviewProduct(ReviewProductRequest $request) {
        if ($request) {
            $data = $request->all();

            $product_id = $data["product_id"];
            $model_product = ArticlesType::find($product_id);
            if ($model_product) {
                $model_user = $this->checkMember();

                $model = new UserReview();
                $model->articles_type_id = $model_product->id;
                $model->full_name = $data["name"];
                $model->email = $data["email"];
                $model->description = $data["description"];
                $model->rate = $data["rating"];
                if ($model_user) {
                    $model->user_id = $model_user->id;
                }
                $model->save();

                $request->session()->flash('alert-success', 'Success: Thank you for your review. It has been submitted to the webmaster for approval!');
                return redirect()->route('frontend.articles.view', ['id' => $model_product->id, 'url' => $model_product->url_title]);
            }
        }

        $request->session()->flash('alert-warning', 'Warning: Review Product Error!');
        return redirect()->route('frontend.articles.index');
    }

}
