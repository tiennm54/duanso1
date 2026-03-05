<div class="row">

    <div class="col-md-12">
        <div class="form-group">
            <label>Here are the Visa/MasterCard payment links for each plan:</label>
        </div>
        <?php if (count($model_children) != 0) { ?>
            <?php
            foreach ($model_children as $key => $item) {
                if ($item->status_stock == 1) {
                    ?>
                    <p>
                        <label><?php echo $item->title; ?>: </label>
                        <span><?php echo URL::route('frontend.fcheckout.view', ["payment_type" => "visa", "product_id" => $item->id, "customer_email" => "CUSTOMER_EMAIL"]); ?></span>
                    </p>
                <?php
                }
            }
            ?>
<?php } ?>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label>Here are the Paypal payment links for each plan:</label>
        </div>
        <?php if (count($model_children) != 0) { ?>
            <?php
            foreach ($model_children as $key => $item) {
                if($item->status_stock == 1) {
                    ?>
                    <p>
                        <label><?php echo $item->title; ?>: </label>
                        <span><?php echo URL::route('frontend.fcheckout.view', ["payment_type" => "paypal", "product_id" => $item->id, "customer_email" => "CUSTOMER_EMAIL"]); ?></span>
                    </p>
        <?php }
    } ?>
<?php } ?>
    </div>

</div>

