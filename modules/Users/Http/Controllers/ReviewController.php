<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modules\Users\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use App\Helpers\SeoPage;
use Illuminate\Http\Request;
use App\Models\Reviews;
use Modules\Users\Http\Controllers\CheckMemberController;
use URL;
use Log;

/**
 * Description of ReviewController
 *
 * @author minht
 */
class ReviewController extends CheckMemberController {

    //put your code here
    public function index(Request $request) {
        SeoPage::seoPage($this);
        $obj_review = new Reviews();
        $review_url = "/".$request->path();
        $model_reviews = $obj_review->getReviews($review_url);
        $data_reviews = $obj_review->countReviews($review_url);
        $model_user = $this->checkMember();
        return view("users::review.index", compact('model_reviews','data_reviews','model_user'));
    }

    public function rateWebsite(Request $request) {
        if (isset($request)) {
            $data = $request->all();
            $url_current = URL::current();
            $model = new Reviews();
            $model->review_name = $data["review_name"];
            $model->review_email = $data["review_email"];
            $model->review_des = $data["review_des"];
            $model->review_rate = $data["review_rate"];
            $model->review_url = $data["review_url"];
            $model->save();
            $request->session()->flash('alert-success', 'Thank you for taking the time to write a review, glad that you had a good experience and we look forward to seeing you again!');
            return back();
        }
        $request->session()->flash('alert-warning', ' Warning: Review Error!');
         return back();
    }

}
