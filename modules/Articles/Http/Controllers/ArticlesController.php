<?php namespace Modules\Articles\Http\Controllers;

use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\PaymentType;
use App\Models\Seo;
use App\Models\TermsConditions;
use Illuminate\Support\Facades\Session;
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

class ArticlesController extends Controller {
	
	public function index()
	{

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            SEOMeta::setTitle($model_seo->seo_title);
            SEOMeta::setDescription($model_seo->seo_description);
            SEOMeta::addKeyword([$model_seo->seo_keyword]);
            SEOMeta::addMeta('article:published_time', $model_seo->created_at->toW3CString(), 'property');
            SEOMeta::addMeta('article:section', 'news', 'property');

            OpenGraph::setTitle($model_seo->seo_title);
            OpenGraph::setDescription($model_seo->seo_description);
            OpenGraph::setUrl(URL::route('frontend.articles.index'));
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png')]);
            OpenGraph::addImage(['url' => url('theme_frontend/image/logo.png'), 'size' => 300]);
            OpenGraph::addImage(url('theme_frontend/image/logo.png'), ['height' => 300, 'width' => 300]);
        }

        $model = Articles::orderBy("position","ASC")->get();
		return view('articles::articles.index', compact("model"));
	}

    //Lựa chọn sản phẩm cần mua
	public function pricing($id = 0){
        $model = Articles::find($id);
        if ($model != null){

            SEOMeta::setTitle($model->seo_title);
            SEOMeta::setDescription($model->seo_description);
            SEOMeta::addKeyword([$model->seo_keyword]);
            SEOMeta::addMeta('article:published_time', $model->created_at, 'property');
            SEOMeta::addMeta('article:section', 'news', 'property');

            OpenGraph::setTitle($model->seo_title);
            OpenGraph::setDescription($model->seo_description);
            OpenGraph::setUrl(URL::route('frontend.articles.view', ['id' => $model->id, 'url' => $model->url_title ]));
            OpenGraph::addProperty('type', 'article');
            OpenGraph::addProperty('locale', 'pt-br');
            OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
            OpenGraph::addImage(['url' => url('images/'. $model->image)]);
            OpenGraph::addImage(['url' => url('images/'. $model->image), 'size' => 300]);
            OpenGraph::addImage(url('images/'. $model->image), ['height' => 300, 'width' => 300]);

            $model_type = ArticlesType::where("articles_id","=",$id)->orderBy("price_order","ASC")->get();
            $model_all_product = Articles::get();
            if (count($model_type) != 0){

                foreach ($model_type as &$product){
                    $product["image"] = $model->image;
                }

                return view('articles::articles.pricing', compact("model", "model_type", "model_all_product"));
            }
        }
        return redirect()->route('frontend.articles.index');
    }

	public function getStateCountry(Request $request){
		if(isset($request)){
			$data = $request->all();
			if(isset($data["country_id"])){
				$countryState = new CountryState();
				$states = $countryState->getStates($data["country_id"]);

//				return Response::json($states);
				return $states;
			}
		}
	}

    public function getSearch(Request $request){

        $data = $request->all();

        if (isset($data["keyword"]) && $data["keyword"] != ""){
            $keyword = $data["keyword"];
            if($keyword != "") {
                $keyword = preg_replace('/[^a-zA-Z0-9 ]/','',$keyword);
                $model = Articles::where("title","LIKE", "%". $keyword. "%")->orderBy("position", "ASC")->get();
                return view('articles::articles.index', compact("model"));
            }
        }
        return redirect()->route('frontend.articles.index');

    }

}