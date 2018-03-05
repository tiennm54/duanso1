@extends('frontend.master')
@section('content')
<div class="product">
    <div class="container">

        <ul class="breadcrumb">
            <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
            <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
        </ul>
        @include('validator.flash-message')
        <div class="row">                
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="title-get-bonus">Get bonus by referring new members</span></div>
                    <div class="panel-body">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $data["link_ref"] }}" id="inputLinkRef">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="copyLinkRef()">Copy</button>
                                </span>
                            </div><!-- /input-group -->
                        </div>
                        <div class="col-lg-6">
                            <span style="font-size: 14px; vertical-align: middle; color: red; font-weight: bold">Bonus {{ $model_bonus_config->bonus_sponsor }}% for sponsor and {{ $model_bonus_config->bonus_reg }}% for buyers per order is successfully transacted.</span>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">
                        Money
                    </div>
                    <div class="tile-body"><i class="fa fa-credit-card"></i>
                        <h2 class="pull-right">{{ ($model->user_money) ? $model->user_money : 0 }}$</h2>
                    </div>
                    <div class="tile-footer"><a data-toggle="modal" data-target="#viewMoney" style="cursor: pointer">View more...</a></div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">
                        Team
                    </div>
                    <div class="tile-body"><i class="fa fa-users"></i>
                        <h2 class="pull-right">{{ ($data["total_team"]) ? $data["total_team"] : 0 }}</h2>
                    </div>
                    <div class="tile-footer"><a href="{{ URL::route('users.team') }}">View more...</a></div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Order History</div>
                    <div class="tile-body"><i class="fa fa-shopping-cart"></i>
                        <h2 class="pull-right">{{ ($data["total_order"]) ? $data["total_order"] : 0 }}</h2>
                    </div>
                    <div class="tile-footer"><a href="{{ URL::route('users.orderHistory') }}">View more...</a></div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="tile">
                    <div class="tile-heading">Wish List</div>
                    <div class="tile-body"><i class="fa fa-heart"></i>
                        <h2 class="pull-right">{{ ($data["total_wish"]) ? $data["total_wish"] : 0 }}</h2>
                    </div>
                    <div class="tile-footer"><a href="{{ URL::route('users.getWishList') }}">View more...</a></div>
                </div>
            </div>

            <div class="col-lg-9">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#total_bonus">Total bonus</a></li>
                    <li><a data-toggle="tab" href="#spending">Your spending</a></li>
                </ul>

                <div class="tab-content">
                    <div id="total_bonus" class="tab-pane fade  in active">
                        @include('users::user.includes.tab_bonus')
                    </div>
                    <div id="spending" class="tab-pane fade">
                        @include('users::user.includes.tab_spending')
                    </div>
                </div>
            </div>
            @include('users::includes.my_account_column_right')
        </div>
    </div>
</div>

@include('users::user.includes.modal_view_money')

<script>

    function copyLinkRef() {
        var copyText = document.getElementById("inputLinkRef");
        /* Select the text field */
        copyText.select();
        /* Copy the text inside the text field */
        document.execCommand("Copy");
        /* Alert the copied text */
        alert("Copied the link: " + copyText.value);
    }

</script>



@stop