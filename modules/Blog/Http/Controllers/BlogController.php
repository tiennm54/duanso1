<?php namespace Modules\Blog\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class BlogController extends Controller {

    public function getCreate(){
        
    }

	
	public function index()
	{
		return view('Blog::index');
	}
	
}