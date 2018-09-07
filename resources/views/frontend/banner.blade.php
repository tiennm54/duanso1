<div class="row" style="margin-bottom: 20px">
    <div class="leo-custom block no-blockshadown hidden-sm hidden-xs clearfix">
        <div class="media-list">
            <div class="col-lg-3 col-md-3 d-none d-sm-none d-md-block">
                <div class="media red">
                    <a class="pull-left" title="">
                        <img class="media-object" src="{{ url('images/blockShadown/reseller_nn.png') }}" alt="Buy premium key reseller" width="78" height="78">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><strong>
                                <a title="">OFFICIAL<br>AUTHORIZED<br>RESELLER</a></strong>
                        </h4>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-3 d-none d-sm-none d-md-block">
                <div class="media blue">
                    <a class="pull-left" title="">
                        <img class="media-object" src="{{ url('images/blockShadown/specials_nn.png') }}" alt="Buy premium key specials" width="78" height="78">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><strong>
                                <a title="">CHEAPEST<br>PRICES<br>SELECTION</a></strong>
                        </h4>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-3 d-none d-sm-none d-md-block">
                <div class="media green">
                    <a class="pull-left" title="">
                        <img class="media-object" src="{{ url('images/blockShadown/recuring_nn.png') }}" alt="Buy premium key recuring" width="78" height="78">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><strong>
                                <a title="">NO<br>RECURING<br>PAYMENT</a></strong>
                        </h4>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-3 d-none d-sm-none d-md-block">
                <div class="media dark">
                    <a class="pull-left" title="">
                        <img class="media-object" src="{{ url('images/blockShadown/delivery_nn.png') }}" alt="buy premium key delivery" width="78" height="78">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <strong><a title="">IMMEDIATE<br>DELIVERY<br>BY EMAIL</a></strong>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-blockshadown {
        background-color: transparent;
        border-radius: 0;
        box-shadow: none;
        padding: 0;
    }
    .no-blockshadown .col-lg-3{
        float: left;
    }
    .media-list {
        padding-left: 0;
        list-style: none;
    }
    .media-list .media {
        border-radius: 5px;
        box-shadow: 0 1px 2px #D9DADB;
        padding: 10px;
        position: relative;
    }
    .media-list .media:before {
        background: none repeat scroll 0 0 rgba(255, 255, 255, 0.1);
        content: "";
        display: inline-block;
        height: 559px;
        position: absolute;
        right: 755px;
        top: 0;
        transform: skew(-45deg);
        transition: all 0.6s ease-in-out 0s;
        width: 600px;
    }
    .media-list .media:hover:before {
        right: -700px;
    }
    .media-list .media.red {
        background-color: #fe6549;
        color: #fff !important;
    }
    .media-list .media.green {
        background-color: #95BB7A;
        color: #fff !important;
    }
    .media-list .media.blue {
        background-color: #57A6B9;
        color: #fff !important;
    }
    .media-list .media.dark {
        background-color: #7F7F7F;
        color: #fff !important;
    }
    .media > .pull-left {
        margin-right: 10px;
    }
    .media-list .media h4.media-heading a {
        color: #fff;
    }
    .media-list .media:first-child {
        margin-top: 0;
    }
    .media-list .media, .media-list .media-body {
        overflow: hidden;
        zoom: 1;
    }
</style>
