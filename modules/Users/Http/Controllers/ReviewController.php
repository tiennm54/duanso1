<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Users\Http\Controllers;
use Pingpong\Modules\Routing\Controller;
use App\Helpers\SeoPage;
/**
 * Description of ReviewController
 *
 * @author minht
 */
class ReviewController extends Controller {
    //put your code here
    public function index(){
        SeoPage::seoPage($this);
        return view("users::review.index");
    }
}
