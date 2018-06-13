<div class="col-md-4">
    <div class="col-md-12 well">

        <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">

        <p class="header-check-out"><i class="glyphicon glyphicon-map-marker"></i> Billing Information</p>

            <div class="form-group col-md-6">
                <label>First Name <span class="input-require"> *</span></label>
                <input type="text" class="form-control" placeholder="First Name"
                       name="first_name"
                       id = "first_name"
                       value="{!! old('first_name',isset($model_user) ? $model_user->first_name : '') !!}"
                       required>
                {!! $errors->first('first_name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
            </div>

            <div class="form-group col-md-6">
                <label>Last Name <span class="input-require"> *</span></label>
                <input type="text" class="form-control" placeholder="Last Name"
                       name="last_name"
                       id = "last_name"
                       value="{!! old('last_name',isset($model_user) ? $model_user->last_name : '') !!}"
                       required>
                {!! $errors->first('last_name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
            </div>

            <div class="form-group col-md-12">
                <label>Email <span class="input-require"> *</span></label>
                <input type="email" class="form-control" placeholder="Email" id="user_orders_email"
                       name="email"
                       value="{!! old('email',isset($model_user) ? $model_user->email : '') !!}"
                       required>
                {!! $errors->first('email','<span class="control-label color-red" style="color: red">*:message</span>') !!}
            </div>
    </div>
    <div class="col-md-12 well">
        <span>
            <b>Note: </b>If you pay with Paypal, please fill your information as your information on paypal. This will help us provide the earliest key for you.
        </span><br/>
        <span>
            If you buy the product uploadgig premium key, please provide us your account on the website uploadgig.com, we will upgrade your account after you make payment completed.
        </span>
    </div>
    
    <div class="col-md-12 well">
        <span>
            When your friends register via the <a href="<?php echo URL::route('users.getMyAccount');?>">link you shared</a> and buy premium key,  you will receive 2% of the total value of the order, and your friend will also receive 2% of the value of the order. 
            This amount will be stored in your account, you can use it to buy any products on our website. 
            If you are a normal buyer, you will still receive 1% bonus from us.
            Share now to receive special offers from BuyPremiumKey reseller
        </span>
    </div>
</div>