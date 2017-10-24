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
use App\Helpers\SeoPage;

class ContactController extends Controller  {

    public function seoContact($model_seo){
        $url_page = URL::route('users.contact.getContact');
        $image_page = url('theme_frontend/image/logo.png');
        SeoPage::createSeo($model_seo, $url_page, $image_page);
    }

    public function getContact(){

        $model_seo = Seo::where("type","=","index")->first();

        if ($model_seo) {
            $this->seoContact($model_seo);
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
                $m->to("buypremiumkey@gmail.com", "BuyPremiumKey Authorized Reseller")->subject('[BuyPremiumKey.Com] Contact by customer');
            });

            $request->session()->flash('alert-success', ' Success: You have successfully sent your contact enquiry');
            return redirect()->route('users.contact.getContact');
        }
    }
}