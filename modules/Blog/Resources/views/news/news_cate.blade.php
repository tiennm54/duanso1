@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li>
                <a href="{{ URL::route('frontend.news.index')}}">News all</a>
            </li>
            <li>
                <a href="{{ $cate->getUrl() }}">
                    <?php echo $cate->name; ?>
                </a>
            </li>
        </ul>

        <div class="row">
            @include('blog::news.includes.list_cate')
            <div id="content" class="col-sm-9">
                <?php if (count($model) == 0) { ?>
                    <h2>There is no news.</h2>
                <?php } ?>
                <?php foreach ($model as $item): ?>
                    <div>
                        
                        <h2>
                            <a href="<?php echo $item->getUrl(); ?>">
                                <?php echo $item->title; ?>
                            </a>
                        </h2>
                        
                        <span class="badge">
                            <i class="glyphicon glyphicon-calendar"></i>
                            <?php echo $item->created_at ?>
                        </span>

                        <span class="badge">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            <?php echo ($item->view) ? $item->view : 0; ?> view
                        </span>

                        <a href="<?php echo $item->getUrl(); ?>" class="btn btn-xs btn-primary pull-right">Read more</a>

                        <hr>
                    </div>
                <?php endforeach; ?>

                <?php echo $model->render(); ?>
            </div>
        </div>
    </div>
</div>
@stop

