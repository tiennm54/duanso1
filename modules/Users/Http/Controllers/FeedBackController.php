<?php

namespace Modules\Users\Http\Controllers;
use Modules\Users\Http\Requests\FeedBackRequest;
use Pingpong\Modules\Routing\Controller;
use App\Helpers\SeoPage;
use App\Models\FeedBack;

class FeedBackController extends Controller {
    
    public function getFeedBack() {
        SeoPage::seoPage($this);
        $attributes = [
            'data-theme' => 'light',
            'data-type' => 'image',
        ];
        return view("users::feedback.create-feedback", compact('attributes'));
    }

    public function postFeedBack(FeedBackRequest $request) {
        if (isset($request)) {
            $model = new FeedBack();
            if(isset($request->name)){
                $model->user_name = $request->name;
            }
            if(isset($request->description)){
                $model->description = $request->description;
            }
            if(isset($request->image)){
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $input['image_name'] = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/images/feedback');
                    $image->move($destinationPath, $input['image_name']);
                    $model->image = $input['image_name'];
                }
            }
            
            $check = $this->checkContentEmail($request->description);
            if($check == true){
                $request->session()->flash('alert-warning', ' Warning: You are trying to spam my website. Your email will be blocked forever.');
                return redirect()->route('users.feedback.getFeedBack');
            }
            
            $model->save();
            $request->session()->flash('alert-success', ' Success: You have successfully sent your feedback. Thank you so much!');
            return redirect()->route('users.feedback.getFeedBack');
        }
    }
    
    public function checkContentEmail($content){
        $blacklistArray = ['http','https'];
        $content = strtolower($content); // chuyen chu hoa thanh chu thuong neu co
        $check = str_contains($content, $blacklistArray);
        if($check == true){
            return true;
        }else{
            return false;
        }
    }

}
