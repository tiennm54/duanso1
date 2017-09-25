<div class="card">
    <div class="header">
        <h1>My Account Information</h1>
    </div>
    <div class="content">
        <form action="" method="POST">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email <span style="color: red">*</span></label>
                        <input required type="text" class="form-control border-input" placeholder="Email" value="{!! old('email',isset($model) ? $model->email : null) !!}" disabled>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>First Name <span style="color: red">*</span></label>
                        <input required type="text" class="form-control border-input" placeholder="First Name" name="first_name" value="{!! old('first_name',isset($model) ? $model->first_name : null) !!}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Last Name <span style="color: red">*</span></label>
                        <input required type="text" class="form-control border-input" placeholder="Last Name" name="last_name" value="{!! old('last_name',isset($model) ? $model->last_name : null) !!}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" class="form-control border-input" placeholder="Company" name="company"
                               value="{!! old('company',(isset($model) && isset($model->profiles)) ? $model->profiles->company : null) !!}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telephone <span style="color: red">*</span></label>
                        <input required type="text" class="form-control border-input" placeholder="Telephone" name="telephone"
                               value="{!! old('telephone',(isset($model) && isset($model->profiles)) ? $model->profiles->telephone : null) !!}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fax</label>
                        <input type="text" class="form-control border-input" placeholder="Fax" name="fax"
                               value="{!! old('fax',(isset($model) && isset($model->profiles)) ? $model->profiles->fax : null) !!}">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address 1 <span style="color: red">*</span></label>
                        <input required type="text" class="form-control border-input" placeholder="Home Address 1" name="street_address_01"
                               value="{!! old('street_address_01',(isset($model) && isset($model->profiles)) ? $model->profiles->street_address_01 : null) !!}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Address 2</label>
                        <input type="text" class="form-control border-input" placeholder="Home Address 2" name="street_address_02"
                               value="{!! old('street_address_02',(isset($model) && isset($model->profiles)) ? $model->profiles->street_address_02 : null) !!}">
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Country <span style="color: red">*</span></label>
                        <select required class="form-control border-input" onchange="changeCountry(this)" name="country">
                            <?php foreach($countries as $key=>$item): ?>
                            <?php
                            $country = "US";
                            if (isset($model) && isset($model->profiles)){
                                $country = $model->profiles->country;
                            }
                            ?>

                            <option value="<?php echo $key;?>" <?php echo ($key == $country) ? "selected" : "";?>><?php echo $item; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>State/Province <span style="color: red">*</span></label>
                        <select required class="form-control border-input" id="state_province" name="state_province">
                            <?php foreach($states as $key=>$item): ?>
                            <?php
                            $state_province = "US";
                            if (isset($model) && isset($model->profiles)){
                                $state_province = $model->profiles->state_province;
                            }
                            ?>

                            <option value="<?php echo $key;?>" <?php echo ($key == $state_province) ? "selected" : "";?>><?php echo $item; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>City <span style="color: red">*</span></label>
                        <input required type="text" class="form-control border-input" placeholder="City" name="city"
                               value="{!! old('city',(isset($model) && isset($model->profiles)) ? $model->profiles->city : null) !!}">
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="number" class="form-control border-input" placeholder="ZIP Code" name="zip_code"
                               value="{!! old('zip_code',(isset($model) && isset($model->profiles)) ? $model->profiles->zip_code : null) !!}">
                    </div>
                </div>
            </div>

            <div class="buttons clearfix">
                <div class="pull-left"><a href="{{ URL::route('users.getMyAccount') }}" class="btn btn-default">Back</a></div>
                <div class="pull-right">
                    <input type="submit" value="Continue" class="btn btn-primary">
                </div>
            </div>

            <div class="clearfix"></div>
        </form>
    </div>
</div>