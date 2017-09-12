<?php namespace Modules\Config\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class ConfigController extends Controller {
	
	public function index()
	{
		return view('Config::index');
	}
	
}