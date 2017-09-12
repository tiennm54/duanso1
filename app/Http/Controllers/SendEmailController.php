<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller{



    public function viewEmail(){
        $data = array('name'=>"Virat Gandhi");

        return view('email.view-email',compact('data'));
    }

    public function sendMail($data, $view_html){

        Mail::send($view_html, $data, function($message) use ($data) {

            $message->from('buypremiumkey@gmail.com','Buy Premium Key');

            $message->to($data["email_customer"], ['data' => $data])->subject($data["subject"]);

        });

        return 1;
    }

}
