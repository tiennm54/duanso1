@extends('frontend.master')
@section('content')
<div class="container">
    <ul class="breadcrumb">
        <li>
            <a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a>
        </li>
        <li>
            <a href="{{ URL::route('frontend.faq.index')}}">News all</a>
        </li>
        <li>
            <a href="{{ $model->getCategoryFaq->getUrl() }}">{{ $model->getCategoryFaq->title }}</a>
        </li>
        <li>
            <a>Faq Detail</a>
        </li>
    </ul>

    <div class="row">
        @include('blog::faq.includes.list_cate')
        <div id="content" class="col-sm-9">
            <h1><span style="color: threedshadow">{{ $model->title }}</span></h1>
            <p>
                <span><?php echo date("F j, Y, g:i a", strtotime($model->created_at));?></span><br/>
                <span>Category: <a href="{{ $model->getCategoryFaq->getUrl() }}" style="cursor: pointer"><?php echo $model->getCategoryFaq->title; ?></a></span>
            </p>
            <p>
                {!! $model->description !!}
            </p>
        </div>
    </div>
</div>
@stop