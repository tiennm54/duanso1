<?php namespace Modules\Articles\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\PaymentType;
use App\Models\TermsConditions;
use App\Models\UserReview;
use Illuminate\Support\Facades\Session;
use Modules\Articles\Http\Requests\ReviewProductRequest;
use Modules\Users\Http\Controllers\CheckMemberController;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Articles\Http\Requests\CreateRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DougSisk\CountryState\CountryState;
use Response;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;

class ArticlesDetailController extends CheckMemberController  {

    public function sumRateProduct($model_product){

        $sum = 0;

        $count_user_rate = count($model_product->getReview);
        if ($count_user_rate == 0){
            return $sum;
        }else{
            $sum = UserReview::where("articles_type_id","=", $model_product->id)->sum("rate") / $count_user_rate;
            return $sum;
        }

    }

    public function view($id = 0){

        $attributes = [
            'data-theme' => 'light',
            'data-type'	=>	'image',
        ];

        $model = ArticlesType::find($id);
        $model_user = $this->checkMember();
        $sum_rate = $this->sumRateProduct($model);

        if ($model){

            SEOMeta::setTitle($model->seo_title);
            SEOMeta::setDescription($model->seo_description);
            SEOMeta::addKeyword([$model->seo_keyword]);
            SEOMeta::addMeta('article:published_time', $model->created_at->toW3CString(), 'property');
            SEOMeta::addMeta('article:section', 'news', 'property');

            OpenGraph::setTitle($model->seo_title);
            OpenGraph::setDescription($model->seo_description);
            OpenGraph::setUrl(URL::route('frontend.articles.view', ['id' => $model->id, 'url' => $model->url_title ]));
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage(['url' => url('images/'. $model->getArticles->image)]);
            OpenGraph::addImage(['url' => url('images/'. $model->getArticles->image), 'size' => 300]);
            OpenGraph::addImage(url('images/'. $model->getArticles->image), ['height' => 300, 'width' => 300]);

            $model_related = ArticlesType::where("articles_id","=",$model->articles_id)->where("id", "!=", $model->id)->get();
            $model_list_product = Articles::orderBy("title","ASC")->get();
            return view('articles::articles.view', compact("model", "model_related", "model_user", "attributes", "sum_rate","model_list_product"));
        }
        return redirect()->route('frontend.articles.index');
    }

    public function reviewProduct(ReviewProductRequest $request){
        if ($request){
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
                return redirect()->route('frontend.articles.view', [ 'id' => $model_product->id, 'url' => $model_product->url_title ]);
            }
        }

        $request->session()->flash('alert-warning', 'Warning: Review Product Error!');
        return redirect()->route('frontend.articles.index');
    }
}