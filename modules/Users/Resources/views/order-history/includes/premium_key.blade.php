<?php if (count($model_key) > 0 && $model->payment_status == "completed") { ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-center">Product Name</td>
                    <td class="text-center">Your Premium Key</td>
                    <td class="text-center">How to activate</td>
                    <td class="text-center">Date sent</td>


                </tr>
            </thead>
            <tbody>
                <?php foreach ($model_key as $item): ?>
                    <tr>
                        <td class="text-center">{{ $item->articles_type_title }}</td>
                        <td class="text-center"><strong style="color: #0000EE">{{ $item->key }}</strong></td>
                        <td class="text-center">
                            <?php
                            if ($item->getLinkActivate()) {
                                $model_activate = $item->getLinkActivate();
                                ?>
                                <a href="<?php echo $model_activate->getUrl(); ?>" target="_blank"><?php echo $model_activate->title; ?></a>
                            <?php } else { ?>
                                <p>N/A</p>
                            <?php } ?>
                        </td>
                        <td class="text-center" style="vertical-align: middle"><span class="label {{ ($item->date_sent) ? "label-primary" : "label-default" }}">{{ ($item->date_sent) ? $item->date_sent : "N/A" }}</span></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php } else if ($model->payment_status == "pending" || $model->payment_status == "paid") { ?>
    <p>Please wait! <strong style="color: red">Your order is being processed...</strong></p>
    <p>After you have paid, if you do not receive premium key in <strong style="color: red"> maximum 8 hours </strong>, please contact us: <span style="font-weight: bold"><a href="mailto:<?php echo EMAIL_BUYPREMIUMKEY; ?>"><?php echo EMAIL_BUYPREMIUMKEY; ?></a></span>. We will check again and send you the premium key/account soon.</p>
    <p>Thanks you for choosing us service. We apologize for any inconvenience this may have caused you.</p>
    <p>Thanks in advance,</p>
    <b>Reseller Team</b>
<?php } else if ($model->payment_status == "echeck") { ?>
    <b>
        Your order is being eChecked by paypal. As soon as this process is complete we will send you a premium key. We apologize for the inconvenience. Please wait more.
    </b>
    <?php } else {
    ?>
    <span class="label label-danger" style="font-size: 15px">The order was canceled!</span>
    <hr>
<?php } ?>