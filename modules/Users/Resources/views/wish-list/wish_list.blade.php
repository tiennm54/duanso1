@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li><a href="#">My Wish List</a></li>
            </ul>
            @include('validator.flash-message')

            <div class="row">
                <div id="content" class="col-sm-9">
                    <h2>My Wish List</h2>
                    <?php if (count($model) == 0):?>
                        <p>Your wish list is empty.</p>
                    <?php endif;?>

                    <?php if (count($model) != 0):?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-center">Image</td>
                                <td class="text-left">Product Name</td>
                                <td class="text-left">Model</td>
                                <td class="text-right">Stock</td>
                                <td class="text-right">Unit Price</td>
                                <td class="text-right">Action</td>
                            </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($model as $item):?>
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ URL::route('frontend.articles.view', [ "id" => $item->articles_type_id, "url" => $item->getArticlesType->url_title.".html" ]) }}">
                                                <img src="{{url('images/'.$item->getArticlesType->getArticles->image)}}" alt="{{ $item->getArticlesType->title }}" title="{{ $item->getArticlesType->title.".html" }}" width="200px">
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            <a href="{{ URL::route('frontend.articles.view', [ "id" => $item->articles_type_id, "url" => $item->getArticlesType->url_title.".html" ]) }}">{{ $item->getArticlesType->title.".html" }}</a>
                                        </td>
                                        <td class="text-left">{{ $item->getArticlesType->code }}</td>
                                        <td class="text-right">
                                            <?php if ($item->getArticlesType->status_stock == 0){
                                                echo "In Stock";
                                            }else{
                                                echo "Not In Stock";
                                            }?></td>
                                        <td class="text-right">
                                                ${{ $item->getArticlesType->price_order }}
                                        </td>
                                        <td class="text-right">
                                            <form method="post" action="{{ URL::route('users.deleteWishList', $item->articles_type_id) }}">
                                                <button type="button" onclick="addToCart({{ $item->articles_type_id }})" data-toggle="modal" data-target="#myModal" class="btn btn-primary"  title="Add to Cart">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>

                                                <button class="btn btn-danger" data-toggle="confirmation" data-placement="left" title="Remove" >
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                    </div>
                    <?php endif; ?>
                    <div class="buttons clearfix">
                        <div class="pull-right">
                            <a href="#account" class="btn btn-primary">Continue</a></div>
                    </div>
                </div>

                @include('users::includes.my_account_column_right')

            </div>


        </div>
    </div>
@stop