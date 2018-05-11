<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

class SendEmailCommentController extends Controller{
    
    public function sendMailReplyComment($model_news, $model_comment, $model_reply){
        $subject_email = SUBJECT_REPLY_COMMENT;
        Mail::send('blog::news.email-reply-comment', ['model_news' => $model_news, 'model_comment' => $model_comment, 'model_reply' => $model_reply], function ($m) use ($model_comment, $subject_email) {
            $m->from(EMAIL_BUYPREMIUMKEY, NAME_COMPANY);
            $m->to($model_comment->email, $model_comment->email)->subject($subject_email);
        });
    }
    
}
