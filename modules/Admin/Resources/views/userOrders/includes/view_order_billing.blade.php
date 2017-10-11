<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <td class="text-left">Billing Information</td>
            <td class="text-left">Shipping Address</td>
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
                Email: {{ $model->email }} <br/>
            </td>
            <td class="text-center">
                <form method="post" action="{{ URL::route('adminUserOrders.sendKey',['id'=>$model->id]) }}">
                    <button class="btn btn-primary" id="btn-send-key" <?php echo ($model->check_send_key == 1) ? "" : "disabled"?>>Send Key</button>
                </form>
            </td>
        </tr>
    </tbody>
</table>