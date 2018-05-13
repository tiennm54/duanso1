@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
            <li>My Wish List</li>
        </ul>
        @include('validator.flash-message')

        <div class="row">
            <div id="content" class="col-sm-9">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            My Wish List
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td class="text-center">Image</td>
                                    <td class="text-left">Product Name</td>

                                    <td class="text-right">Stock</td>
                                    <td class="text-right">Unit Price</td>
                                    <td class="text-right" width="15%">Action</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (count($model) == 0): ?>
                                    <tr>
                                        <td colspan="5">Your wish list is empty.</td>
                                    </tr>
                                <?php endif; ?>

                                <?php foreach ($model as $item): ?>
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ $item->getArticlesType->getUrl() }}">
                                                <img src="{{url('images/'.$item->getArticlesType->getArticles->image)}}" alt="{{ $item->getArticlesType->title }}" title="{{ $item->getArticlesType->title.".html" }}" width="200px">
                                            </a>
                                        </td>

                                        <td class="text-left">
                                            <a href="{{ $item->getArticlesType->getUrl() }}">{{ $item->getArticlesType->title.".html" }}</a>
                                        </td>

                                        <td class="text-center" style="vertical-align: middle">
                                            <?php if ($item->getArticlesType->status_stock == 1) { ?>
                                                <span class="label label-primary">In Stock</span>
                                            <?php } else { ?>
                                                <span class="label label-danger">Not In Stock</span>
                                            <?php } ?>
                                        </td>

                                        <td class="text-right">
                                            ${{ $item->getArticlesType->price_order }}
                                        </td>

                                        <td class="text-center">
                                            <form method="post" action="{{ URL::route('users.deleteWishList', $item->articles_type_id) }}">
                                                <button type="button" onclick="addToCart({{ $item->articles_type_id }})" data-toggle="modal" data-target="#myModal" class="btn btn-primary"  title="Add to Cart" <?php echo ($item->getArticlesType->status_stock == 0) ? "disabled" : "" ?>>
                                                    <i class="fa fa-shopping-cart"></i>
                                                </button>

                                                <button class="btn btn-danger" data-toggle="confirmation" data-placement="left" title="Remove" >
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                </div>

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