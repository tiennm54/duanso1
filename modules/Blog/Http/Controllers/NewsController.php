<?php

namespace Modules\Blog\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\NewsComment;
use Modules\Blog\Http\Requests\CommentRequest;
use Modules\Blog\Http\Requests\CommentReplyRequest;
use Modules\Blog\Http\Requests\EditCommentRequest;
use Modules\Users\Http\Controllers\CheckMemberController;
use App\Http\Controllers\SendEmailCommentController;
use App\Helpers\SeoPage;
use URL;
use Log;

class NewsController extends CheckMemberController {

    public function seoNewsCate($model) {
        $url_page = $model->getUrl();
        $image_page = "";
        if ($model->image) {
            $image_page = url('images/news/' . $model->image);
        }
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    public function seoNewsView($model) {
        $url_page = $model->getUrl();
        $image_page = "";
        if ($model->image) {
            $image_page = url('images/news/' . $model->image);
        }
        SeoPage::createSeo($model, $url_page, $image_page);
    }

    public function index() {
        SeoPage::seoPage($this);
        $model_cate = Category::orderBy("id", "ASC")->get();
        $model = News::orderBy("id", "DESC")->paginate(NUMBER_PAGE);
        return view('blog::news.index', compact("model", "model_cate"));
    }

    public function newsCate($id) {
        $cate = Category::find($id);
        if ($cate) {
            $model = News::where("category_id", "=", $id)->orderBy("id", "DESC")->paginate(NUMBER_PAGE);
            $model_cate = Category::orderBy("id", "ASC")->get();
            $this->seoNewsCate($cate);
            return view('blog::news.news_cate', compact("model", "model_cate", "cate"));
        }
        return redirect()->route('frontend.news.index');
    }

    public function view($id) {
        $model_cate = Category::orderBy("id", "ASC")->get();
        $model = News::find($id);
        if ($model) {
            $this->seoNewsView($model);

            $model->view = $model->view + 1;
            $model->save();
            $attributes = [
                'data-theme' => 'light',
                'data-type' => 'image',
            ];
            $model_comment = NewsComment::where("news_id", $id)->orderBy("flag", "ASC")->get();
            $model_user = $this->checkMember();
            return view('blog::news.view', compact("model", "model_cate", "attributes", "model_comment", "model_user"));
        }
        return redirect()->route('frontend.news.index');
    }

    public function createAvatar() {
        $avatar_number = rand(1, 5);
        $avatar_name = "avatar-user-" . $avatar_number . '.png';
        return $avatar_name;
    }

    public function postComment($id, CommentRequest $request) {
        if (isset($request)) {
            $model_news = News::find($id);
            if ($model_news) {
                $avatar_name = $this->createAvatar();
                $model = new NewsComment();
                $model->email = $request->email;
                $model->comment = $request->comment;
                $model->avatar = $avatar_name;
                $model->news_id = $id;
                $model->save();
                $model->flag = $model->id;
                $model->save();
                $request->session()->flash('alert-success', ' Success: Your comment has been successfully sent. Thanks you!');
                return back();
            }
        }
        $request->session()->flash('alert-warning', ' Warning: You can not post to this comment. Please check again.');
        return back();
    }

    public function postCommentReply($id, CommentReplyRequest $request) {
        if (isset($request)) {
            $model_news = News::find($id);
            if ($model_news) {
                $model_comment = NewsComment::find($request->id_comment);
                if ($model_comment) {
                    $obj_reply = new NewsComment();
                    $model_reply = $obj_reply->createReplyComment($model_comment, $request->email_reply, $request->comment_reply, false);
                    //SEND EMAIL THONG BAO TOI NGUOI COMMENT
                    $send_mail = new SendEmailCommentController();
                    $send_mail->sendMailReplyComment($model_news, $model_comment, $model_reply);
                    $request->session()->flash('alert-success', ' Success: Your reply has been successfully sent. Thanks you!');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', ' Warning: You can not post to this reply. Please check again.');
        return back();
    }

    public function editComment(EditCommentRequest $request) {
        if (isset($request)) {
            $model_comment = NewsComment::find($request->id_comment_edit);
            if ($model_comment) {
                $model_user = $this->checkMember();
                if ($model_user && $model_user->email == $model_comment->email) {
                    $model_comment->comment = $request->comment_edit;
                    $model_comment->save();
                    $request->session()->flash('alert-success', ' Success: Edit comment success!');
                    return back();
                }
            }
        }
        $request->session()->flash('alert-warning', ' Warning: Edit comment error!');
        return back();
    }

}
