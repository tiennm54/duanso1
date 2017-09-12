@extends('frontend.master')
@section('content')
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li>
                <a href="{{ URL::route('frontend.information.view', ['id' => $model->id, "url" => $model->url_title.".html" ]) }}">{{ $model->title }}</a>
            </li>
        </ul>

        <div class="row">
            <div id="content" class="col-sm-12">
                <h1>{{ $model->title }}</h1>
                <p>
                    {!! $model->description !!}
                </p>
            </div>
        </div>
    </div>
@stop