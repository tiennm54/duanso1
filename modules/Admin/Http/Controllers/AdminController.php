<?php namespace Modules\Admin\Http\Controllers;

use App\Models\ArticlesType;
use App\Models\ArticlesTypeDes;
use Pingpong\Modules\Routing\Controller;

class AdminController extends Controller {

    public function __construct(){
        $this->middleware("role");
    }

	public function index()
	{
		return view('admin::index');
	}


	public function taoTieuChi(){
        $model = ArticlesType::get();
        foreach ($model as $item){
            $item->url_title = str_slug($item->title, '-')."-".'reseller';
            $item->save();
        }
    }
	
}