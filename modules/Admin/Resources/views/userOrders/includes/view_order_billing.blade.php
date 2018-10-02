<form method="post" action="{{ URL::route('adminUserOrders.sendKey',['id'=>$model->id]) }}">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left">Billing Information</td>
                    <td class="text-left" width="30%">Status paypal received</td>
                    <td class="text-center">Send Premium Key</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">
                        Full name: {{ $model->first_name }} {{ $model->last_name }} <br/>
                        Email: {{ $model->email }} <br/>
                        Telephone: {{ ($model->telephone) ? $model->telephone : "N/A" }} <br/>
                        Address: {{ ($model->address) ? "$model->address" : "N/A"}} <br/>
                        City: {{ ($model->city) ? $model->city : "N/A" }} <br/>
                        Zip code: {{ ($model->zip_code) ? $model->zip_code : "N/A" }} <br/>
                        Country: {{ ($model->country_name) ? $model->country_name : "N/A" }} <br/>
                        State province: {{ ($model->state_name) ? $model->state_name : "N/A" }} <br/>
                    </td>
                    <td class="text-left">
                        <select class="form-control" name="status_paypal_receive">
                            <option value="completed">Activate</option>
                            <option value="pending">Hold</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-primary" id="btn-send-key" <?php echo ($model->check_send_key == 1) ? "" : "disabled" ?> data-toggle="confirmation">Send Key</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</form>