<?php

namespace Modules\Users\Http\Controllers;

use Modules\Users\Http\Requests\ContactRequest;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;
use Log;

class ContactController extends Controller {

    public function getContact() {
        SeoPage::seoPage($this);
        $attributes = [
            'data-theme' => 'light',
            'data-type' => 'image',
        ];
        return view("users::contact.form-contact", compact('attributes'));
    }

    public function postContact(ContactRequest $request) {
        if (isset($request)) {
            $data = $request->all();
            $check = $this->checkContentEmail($data);
            if($check == true){
                $request->session()->flash('alert-warning', ' Warning: You are trying to spam my website. Your email will be blocked forever.');
                return redirect()->route('users.contact.getContact');
            }
            try {
                Mail::send('users::email.email-contact', ['user' => $data], function ($m) use ($data) {
                    $m->from($data["email"], $data["email"]);
                    $m->to(EMAIL_BUYPREMIUMKEY, NAME_COMPANY)->subject(SUBJECT_CONTACT);
                });
            } catch (\Exception $e) {
                Log::info("LOI SEND EMAIL");
            }

            $request->session()->flash('alert-success', ' Success: You have successfully sent your contact enquiry');
            return redirect()->route('users.contact.getContact');
        }
    }
    
    public function checkContentEmail($data){
        $content = $data["enquiry"];
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
