<div class="col-md-4">
    <div class="col-md-12 well">

        <input id="_token" type="hidden" name="_token" value="{{ csrf_token() }}">

        <p class="header-check-out"><i class="glyphicon glyphicon-map-marker"></i> Billing Information</p>

            <div class="form-group col-md-6">
                <label>First Name <span class="input-require"> *</span></label>
                <input type="text" class="form-control" placeholder="First Name"
                       name="first_name"
                       value="{!! old('first_name',isset($model_user) ? $model_user->first_name : '') !!}"
                       required>
                {!! $errors->first('first_name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
            </div>

            <div class="form-group col-md-6">
                <label>Last Name <span class="input-require"> *</span></label>
                <input type="text" class="form-control" placeholder="Last Name"
                       name="last_name"
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
</div>