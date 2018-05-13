@extends('frontend.master')
@section('content')
<div class="container">
    <ul class="breadcrumb">
        <li>
            <a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a>
        </li>
        <li>
            <a href="{{ URL::route('frontend.news.index')}}">News all</a>
        </li>
        <li>
            <a href="{{ $model->getCategory->getUrl() }}">{{ $model->getCategory->name }}</a>
        </li>
        <li>
            <a>News detail</a>
        </li>
    </ul>

    <div class="row">
        @include('blog::news.includes.list_cate')
        <div id="content" class="col-sm-9">
            <h1>{{ $model->title }}</h1>
            <p>
                {!! $model->description !!}
            </p>
            <hr>

            <div class="page-header">
                <h3 class="reviews">Leave your comment</h3>
            </div>
            @include('validator.validator-input')
            @include('validator.flash-message')
            <div class="comment-tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#comments-logout" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Comments</h4></a></li>
                    <li><a href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Add comment</h4></a></li>
                </ul>            
                <div class="tab-content">
                    <div class="tab-pane active" id="comments-logout">                
                        @include('blog::news.includes.list_comment')
                    </div>
                    <div class="tab-pane" id="add-comment">
                        @include('blog::news.includes.add_comment')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('blog::news.includes.modal_reply')
@include('blog::news.includes.modal_edit_comment')

<script>
    function replyComment(id, email, comment){
        $("#header_email_comment").html("@" + email);
        $("#header_comment").html(comment);
        $("#id_comment").val(id);
    }
    
    function editComment(id, email){
        $("#id_comment_edit").val(id);
        $("#comment_edit").val(email);
    }
    
    function countCharactersComment() {
        var des = $(".des-comment").val();
        var count = des.length;
        $(".count-characters").text(count)
    }
</script>

@stop