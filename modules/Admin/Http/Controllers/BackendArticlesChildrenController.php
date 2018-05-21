<?php

namespace Modules\Admin\Http\Controllers;
use App\Models\Articles;
use App\Models\ArticlesType;
use App\Models\ArticlesTypeDes;
use App\Models\ArticlesTypeKey;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\ArticlesChildrenRequest;
use Pingpong\Modules\Routing\Controller;
use DB;

class BackendArticlesChildrenController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

    public function getCreate($articles_id){
        $model_articles = Articles::find($articles_id);
        if ($model_articles != null){
            return view('admin::articlesChildren.create',compact('model_articles'));
        }else{
            return view('errors.503');
        }
    }

    public function postCreate(ArticlesChildrenRequest $request, $articles_id){

        if (isset($request)){
            $model_articles = Articles::find($articles_id);
            if ($model_articles != null){
                DB::beginTransaction();
                $model = new ArticlesType();
                $model->articles_id = $model_articles->id;
                $model->title = $request->txt_title;
                $model->code = $request->txt_code;
                $model->price_order = $request->decimal_price_order;
                $model->description = $request->txt_description;
                $model->status_stock = $request->int_instock;
                $model->url_title = str_slug($request->txt_title, '-').'-'.'reseller';
                $model->seo_title = $request->txt_seo_title;
                $model->seo_description = $request->txt_seo_description;
                $model->seo_keyword = $request->txt_seo_keyword;
                $model->save();

                //Save description for articles type
                $des = $request->des;
                foreach ($des as $item){
                    if($item != "") {
                        $model_des = new ArticlesTypeDes();
                        $model_des->product_id = $model->id;
                        $model_des->description = $item;
                        $model_des->save();
                    }
                }

                DB::commit();
                return redirect()->route('articlesChildren.getEdit', ["id" => $model->id]);

            }
        }
        return view('errors.503');
    }

    public function view($id){
        $model = ArticlesType::find($id);
        if ($model != null){
            $model_articles = Articles::find($model->articles_id);
            if ($model_articles != null){

                $model_key = ArticlesTypeKey::where("status","=","active")
                    ->where("articles_type_id","=", $id)
                    ->orderBy("id","DESC")
                    ->get();

                return view('admin::articlesChildren.view',compact('model','model_articles','model_key'));
            }
        }
        return view('errors.503');
    }

    public function getEdit($id){
        $model = ArticlesType::find($id);
        if ($model != null){
            $model_articles = Articles::find($model->articles_id);
            if ($model_articles != null) {
                return view('admin::articlesChildren.edit', compact('model', 'model_articles'));
            }
        }
        return view('errors.503');
    }

    public function postEdit(ArticlesChildrenRequest $request, $id){
        if (isset($request)){
            $model = ArticlesType::find($id);
            if ($model != null){
                $model_articles = Articles::find($model->articles_id);
                if ($model_articles != null){
                    DB::beginTransaction();
                    $model->title = $request->txt_title;
                    /*if (isset($request->txt_url_title)) {
                        $model->url_title = $request->txt_url_title;
                    }*/
                    $model->code = $request->txt_code;
                    $model->price_order = $request->decimal_price_order;
                    $model->description = $request->txt_description;
                    $model->status_stock = $request->int_instock;
                    $model->seo_title = $request->txt_seo_title;
                    $model->seo_description = $request->txt_seo_description;
                    $model->seo_keyword = $request->txt_seo_keyword;
                    $model->save();

                    //Save description for articles type
                    ArticlesTypeDes::where("product_id","=", $model->id)->delete();
                    $des = $request->des;
                    foreach ($des as $item){
                        if($item != "") {
                            $model_des = new ArticlesTypeDes();
                            $model_des->product_id = $model->id;
                            $model_des->description = $item;
                            $model_des->save();
                        }
                    }

                    DB::commit();
                    $request->session()->flash('alert-success', 'Success: Update Completed!');
                    return back();
                }
            }
        }
        return view('errors.503');
    }


    public function addKeyToProduct($id, Request $request)
    {
        if (isset($request)){
            $data = $request->all();
            if ($data["product_key"]){
                $model_product = ArticlesType::find($id);
                if ($model_product){
                    $model = new ArticlesTypeKey();
                    $model->articles_type_id = $model_product->id;
                    $model->key = $data["product_key"];
                    $model->save();
                    $request->session()->flash('alert-success', 'Success: Cập nhật key thành công, chúc Minh Tiến một ngày gặt hái được nhiều thành công!');
                }else{
                    $request->session()->flash('alert-warning', 'Warning: Bị lỗi rồi, Minh Tiến hãy cố gắng và vui lòng thực hiện lại!');
                }
            }else{
                $request->session()->flash('alert-warning', 'Warning: Bị lỗi rồi, Minh Tiến hãy cố gắng và vui lòng thực hiện lại!');
            }
        }else{
            $request->session()->flash('alert-warning', 'Warning: Bị lỗi rồi, Minh Tiến hãy cố gắng và vui lòng thực hiện lại!');
        }

        return back();
    }


    public function autoComplete(Request $request){
        if (isset($request)) {
            $data = ArticlesType::select(
                "id",
                "title as name"
            )->where("title", "LIKE", "%{$request->input('query')}%")->get();
            return response()->json($data);
        }
    }


    public function delete($id, Request $request){
        $model = ArticlesType::find($id);
        if ($model != null){
            $model->delete();
            $request->session()->flash('alert-success', 'Success: Xóa thành công!');
            return back();
        }else{
            return view('errors.503');

        }
    }

}