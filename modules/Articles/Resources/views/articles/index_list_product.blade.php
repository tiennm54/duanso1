@extends('frontend.master')

@section('content')

    <div class="container">

        @include('validator.flash-message')

        <div class="row">
            <div id="content" class="col-sm-12">

                <div class="row">
                    <?php if(count($model) == 0){
                        echo "There is no product that matches the search criteria.";
                    }?>
                    <?php foreach ($model as $key=>$item): ?>
                    <div class="col-md-4">
                        <div class="product-thumb">
                            <a href="{{ $item->getUrlPricing() }}">
                                <h3>{{ $item->title }} Premium Key</h3>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>

@stop