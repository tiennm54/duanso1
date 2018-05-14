<?php

namespace Modules\Admin\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\NewsComment;
use App\Models\News;
use App\Http\Controllers\SendEmailCommentController;
use Log;

class CommentManagerController extends Controller {

    public function __construct() {
        $this->middleware("editor");
    }

    public function index() {
        $model = NewsComment::orderBy("id", "DESC")->where("parent_id", 0)->paginate(NUMBER_PAGE);
        return view('admin::comment.index', compact('model'));
    }

    public function view($id) {
        $model = NewsComment::find($id);
        if ($model) {
            $model_reply = NewsComment::where("parent_id", $model->id)->orderBy("id", "ASC")->get();
            return view('admin::comment.view', compact('model', 'model_reply'));
        }
    }

    public function disableComment($id, Request $request) {
        if (isset($request)) {
            $model_comment = NewsComment::find($id);
            if ($model_comment) {
                $model_comment->status_disable = $request->status_disable;
                $model_comment->save();
                $request->session()->flash('alert-success', ' Success: Save status success!');
                return back();
            }
        }
        $request->session()->flash('alert-warning', ' Warning: Save status error!');
        return back();
    }

    public function reply($id, Request $request) {
        if (isset($request)) {
            $model_comment = NewsComment::find($id);
            if ($model_comment) {
                $model_news = News::find($model_comment->news_id);
                if ($model_news) {
                    $obj_reply = new NewsComment();
                    $model_reply = $obj_reply->createReplyComment($model_comment, "Admin", $request->reply_comment, true);
                    $send_mail = new SendEmailCommentController();
                    $send_mail->sendMailReplyComment($model_news, $model_comment, $model_reply);

                    $request->session()->flash('alert-success', ' Success: Your comment has been successfully sent. Thanks you!');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', ' Warning: You can not post to this comment. Please check again.');
        return back();
    }

    public function editComment(Request $request) {
        if (isset($request)) {
            $id = $request->id_comment_edit;
            $comment = $request->comment_edit;
            $model_comment = NewsComment::find($id);
            if ($model_comment) {
                $model_comment->comment = $comment;
                $model_comment->save();
                $request->session()->flash('alert-success', ' Success: Edit comment success!');
                return back();
            }
        }
        $request->session()->flash('alert-warning', ' Warning: Edit comment error!');
        return back();
    }
    
    public function deleteComment($id, Request $request){
        $model_comment = NewsComment::find($id);
        if($model_comment){
            $check = NewsComment::where("parent_id","=",$model_comment->id)->first();
            if($check == null){
                $model_comment->delete();
                $request->session()->flash('alert-success', ' Success: Delete comment success!');
            }else{
                $request->session()->flash('alert-warning', ' Warning: Comment đã có reply!');
            }
            return back();
        }
        $request->session()->flash('alert-warning', ' Warning: Edit comment error!');
        return back();
    }

}
