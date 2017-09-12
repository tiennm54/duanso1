@extends('frontend.master')
@section('content')

    <div class="product">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li><a href=#">Edit Information</a></li>
            </ul>

            @include('validator.flash-message')

            <div class="container-fluid">
                <div class="row">
                <div class="col-sm-9">
                    @include('users::includes.profiles_infomation',compact('model','countries','states'))
                </div>
                    @include('users::includes.my_account_column_right')
            </div>
            </div>
        </div>
    </div>


    <script>
        function changeCountry(item){
            //var token = $("#_token").val();
            $.ajax({
                type: 'GET',
                url: "<?php echo URL::route('users.getStateCountry') ?>",
                data: {"country_id" : item.value},
                success: function (data) {
                    var s = "";
                    jQuery.each(data, function(key, value) {
                        s += "<option value=" + key + ">" + value+ "</option>";
                    });
                    $('#state_province').find('option').remove().end().append(s);
                },
                error: function (ex) {

                }
            });
        }

    </script>

@stop