<?php if(count($model_key) > 0 && $model->payment_status == "completed"){?>
    <div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td class="text-left">Product Name</td>
            <td class="text-left">Premium Key</td>
            <td class="text-left">Date sent</td>
            <td class="text-left">Price</td>

        </tr>
        </thead>
        <tbody>
            <?php foreach ($model_key as $item):?>
            <tr>
                <td class="text-left">{{ $item->articles_type_title }}</td>
                <td class="text-left">{{ $item->key }}</td>
                <td class="text-left" style="vertical-align: middle"><span class="label {{ ($item->date_sent) ? "label-primary" : "label-default" }}">{{ ($item->date_sent) ? $item->date_sent : "N/A" }}</span></td>
                <td class="text-left" style="vertical-align: middle"><span class="label label-default">${{ $item->articles_type_price }}</span></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<?php }else{?>
    <p>Please wait! Your payment is processing.</p>
    <p>After paid if you do not receive premium in maximum 12 hours, please contact us: <span style="font-weight: bold"><a href="mailto:buypremiumkey.com@gmail.com">buypremiumkey.com@gmail.com</a></span>. We will check again and send you the premium key/account</p>
    <p>Thanks you for choosing us service. We apologize for any inconvenience this may have caused you.</p>
    <p>Thanks in advance,</p>
    <b>Reseller Team</b>
<?php }?>