<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model {

    protected $table = 'news_comment';
    public $timestamps = true;

    public function getNews() {
        return $this->hasOne('App\Models\News', 'id', 'news_id');
    }
    public function createReplyComment($model_comment, $email_reply, $reply_comment, $type) {
        $this->email = $email_reply;
        $this->comment = $reply_comment;
        $this->news_id = $model_comment->news_id;
        $this->flag = $model_comment->flag;
        $this->reply_email = $model_comment->email;
        $this->parent_id = $model_comment->id;
        if ($type == true) {//loai comment cua admin
            $this->type = "1";
            $this->avatar = "avatar-admin.png";
        } else {
            $this->avatar = $model_comment->avatar;
        }
        $this->save();
        if ($type == true) {
            $model_comment->status_admin_reply = 1; // admin đã reply
            $model_comment->save();
        }
        
        return $this;
    }

}
