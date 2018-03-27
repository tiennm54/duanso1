@extends('frontend.master')
@section('content')
    <div class="product">
        <div class="container">

            <ul class="breadcrumb">
                <li><a href="{{ URL::route('frontend.articles.index') }}"><i class="fa fa-home"></i></a></li>
                <li><a href="{{ URL::route('users.getMyAccount') }}">Account</a></li>
                <li>Shipping Address</li>
            </ul>

            @include('validator.flash-message')

            <div class="row">
                    <div id="content" class="col-sm-9">
                        <h2>Shipping Address</h2>

                        <form action="{{ URL::route('users.shippingAddress.addShippingAddress') }}" method="POST">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control border-input" 
                                               placeholder="Email" name="email" 
                                               value="{!! old('email') !!}"
                                               required/>
                                        {!! $errors->first('email','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-original-title="Add shipping address"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <?php if (count($model) == 0){
                            echo "You have not shipping address!";
                        }else{?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <?php foreach ($model as $item):?>
                                        <tr>
                                            <td class="text-left">
                                                {{ $item->email }}
                                            </td>




                                            <td class="text-center">
                                                <?php if ($item->status != "default"){ ?>
                                                    <form action="{{ URL::route('users.shippingAddress.deleteShippingAddress',$item->id) }}" method="POST" onsubmit="return confirmDelete()" class="col-md-1 pull-left">
                                                        <button type="submit" class="btn btn-danger" title="Delete">
                                                            <i class="fa fa-trash-o"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ URL::route('users.shippingAddress.setPrimaryShippingAddress',$item->id) }}" method="POST" class="col-md-4 pull-left">
                                                        <button class="btn btn-warning btn-xs" title="Set Primary">Set Primary</button>
                                                    </form>

                                                <?php }else{?>
                                                    <p class="col-md-4 "><span class="btn btn-primary btn-xs pull-left">Primary</span></p>

                                                <?php }?>
                                            </td>


                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>

                        <?php }?>

                        <div class="buttons clearfix">
                        <div class="pull-left">
                            <a onclick="goBack()" class="btn btn-default">Back</a>
                        </div>

                        <div class="pull-right">
                            <a href="{{ URL::route('frontend.checkout.index') }}" class="btn btn-primary">Continue</a>
                        </div>
                    </div>
                </div>

                @include('users::includes.my_account_column_right')

            </div>

        </div>
    </div>
@stop