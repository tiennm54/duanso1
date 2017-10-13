<div class="col-md-4">
    <div class="col-md-12 well">

        <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">

        <p class="header-check-out"><i class="glyphicon glyphicon-map-marker"></i> Billing Information</p>

        <?php if (Auth::check()){ ?>
            <div class="form-group col-md-12">
                <label>Shipping Address <span class="input-require"> *</span></label>
                <select class="form-control" name="shipping_address">
                    <?php if(isset($model_user->shippingAddress) && count($model_user->shippingAddress) != 0){?>
                        <?php foreach ($model_user->shippingAddress as $item):?>
                            <option value="{{ $item->email }}" <?php echo ($item->status == "default") ? "selected" : "";?>>{{ $item->email }}</option>
                        <?php endforeach; ?>
                    <?php }else{?>
                        <option value="{{$model_user->email}}">{{ $model_user->email }}</option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-12">
                <a href="{{ URL::route('users.shippingAddress.getShippingAddress') }}" class="btn btn-primary" style="margin-bottom: 10px;" data-toggle="tooltip" data-original-title="Add shipping address">
                    <i class="fa fa-plus"> Add</i>
                </a>
            </div>

        <?php }else{ // Neu khon dang nhap thi hien thi form ?>
            <div class="form-group col-md-6">
                <label>First Name <span class="input-require"> *</span></label>
                <input type="text" class="form-control" placeholder="First Name"
                       name="first_name"
                       value="{!! old('first_name',isset($model_user) ? $model_user->first_name : null) !!}"
                       <?php if ($model_user){ echo "disabled"; } ?>
                       required>
            </div>

            <div class="form-group col-md-6">
                <label>Last Name <span class="input-require"> *</span></label>
                <input type="text" class="form-control" placeholder="Last Name"
                       name="last_name"
                       value="{!! old('last_name',isset($model_user) ? $model_user->last_name : null) !!}"
                       <?php if ($model_user){ echo "disabled"; } ?>
                       required>
            </div>

            <div class="form-group col-md-12">
                <label>Email <span class="input-require"> *</span></label>
                <input type="email" class="form-control" placeholder="Email" id="user_orders_email"
                       name="email"
                       value="{!! old('email',isset($model_user) ? $model_user->email : null) !!}"
                       <?php if ($model_user){ echo "disabled"; } ?>
                       required>
                {!! $errors->first('email','<span class="control-label color-red" style="color: red">*:message</span>') !!}
            </div>
        <?php }?>

    </div>
</div>