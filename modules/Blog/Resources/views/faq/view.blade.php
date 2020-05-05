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
            <div class="page-title">
                <h1>{{ $model->title }}</h1>
            </div>
            <p>
                <span><?php echo date("F j, Y, g:i a", strtotime($model->created_at)); ?></span><br/>
                <span>Category: <a href="{{ $model->getCategoryFaq->getUrl() }}" style="cursor: pointer"><?php echo $model->getCategoryFaq->title; ?></a></span>
                <?php if ($model->getProduct): ?>
                    <span> | Product: <a href="{{ $model->getProduct->getUrlPricing() }}" style="cursor: pointer"><?php echo $model->getProduct->title; ?></a></span>
                <?php endif; ?>
            </p>
            <p>
                {!! $model->description !!}
            </p>
        </div>
    </div>

    <div class="row" style="margin-bottom: 20px">
        <?php if (count($model_related)) { ?>
            <div class="col-md-12">
                <div class="page-title">
                    <h1>Related articles</h1>
                </div>
            </div>
            <?php foreach ($model_related as $item_article): ?>
                <div class="col-md-6">
                    <a href="{{ $item_article->getUrl() }}">{{ $item_article->title }}</a>
                </div>
            <?php endforeach; ?>
        <?php } ?>
    </div>

</div>
@stop