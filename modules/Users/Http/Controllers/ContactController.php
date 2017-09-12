<?php

namespace Modules\Users\Http\Controllers;
use Modules\Users\Http\Requests\ContactRequest;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use SEOMeta;
use OpenGraph;
use Twitter;
use URL;
use App\Models\Seo;

class ContactController extends Controller  {

    public function getContact(){

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            SEOMeta::setTitle("Contact Premium Key - ".$model_seo->seo_title);
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

        $attributes = [
            'data-theme' => 'light',
            'data-type'	=>	'image',
        ];

        return view("users::contact.form-contact", compact('attributes'));
    }


    public function postContact(ContactRequest $request){
        if (isset($request)){
            $data = $request->all();

            Mail::send('users::email.email-contact', ['user' => $data], function ($m) use ($data) {
                $m->from($data["email"], $data["email"]);
                $m->to("buypremiumkey@gmail.com", "Buy Premium Key")->subject('[BuyPremiumKey.Com] Contact');
            });

//            Mail::send('users::email.email-contact-member', ['user' => $data], function ($m) use ($data) {
//                $m->from("buypremiumkey@gmail.com", "Buy Premium Key");
//                $m->to($data["email"], $data["name"])->subject('[BuyPremiumKey.Com] Your Contact');
//            });

            $request->session()->flash('alert-success', ' Success: You have successfully sent your contact enquiry');
            return redirect()->route('users.contact.getContact');
        }
    }
}