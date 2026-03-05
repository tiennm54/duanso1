<!DOCTYPE html>
<html>
    <head>
        <title>INVOICE #<?php echo $model->order_no; ?></title>
        <link href="{{url('theme_frontend/css/bootstrap.css')}}" rel="stylesheet" media="screen">
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script src="{{url('theme_frontend/js/jquery-2.1.1.min.js')}}" type="text/javascript"></script>
    </head>
    <body>
        <div class="product">
            <div class="container">
                @include('validator.flash-message')
                <div class="row">
                    <div id="content" class="col-sm-12">
                        <div class="page-title">
                            <h2>TRACK YOUR INVOICE #<?php echo $model->order_no; ?></h2>
                        </div>

                        <div class="tab-content">
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left"><b>Product</b></td>
                                                <td class="text-center"><b>Your Premium Key</b></td>
                                                <td class="text-center"><b>How to activate</b></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (count($model_key) > 0 && $model->payment_status == "completed") { ///DA CO KEY ?>
                                                <?php foreach ($model_key as $item): ?>
                                                    <tr>
                                                        <td class="text-left">{{ $item->articles_type_title }}</td>
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
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php } else { ?>
                                                <?php if (count($model_product) == 0): ?>
                                                    <tr>
                                                        <td class="text-left" colspan="3">Your shopping cart is empty!</td>
                                                    </tr>
                                                <?php endif; ?>
                                                <?php if (count($model_product) > 0): ?>
                                                    <?php foreach ($model_product as $item): ?>
                                                        <tr>
                                                            <td class="text-left">
                                                                <img src="{{ $item->articles_type->getArticles->getImage() }}" style="width: 100px"/>
                                                                {{ $item->articles_type->title }}
                                                            </td>
                                                            <td class="text-center">WAITING...</td>
                                                            <td class="text-center">WAITING...</td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>

                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                                <td colspan="3">
                                                    <b>The Invoice has been sent to your email</b>: <?php echo $model->email;?>
                                                </td>
                                             </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <p style="font-weight: bold">How do you pay for this Invoice?</p>
                                                    <p>
                                                        <span>  We have sent a PayPal Invoice to your email. Please check your inbox or <span style="color: red">spam folder</span> for the invoice. After that, kindly click on the <span style="font-weight: bold;">"Check out with paypal"</span> button in the invoice to complete the payment.</span><br/>
                                                        <span>  Once your payment is successful, we will send the premium key to your email or you can get your premium key on this page. 
                                                            If you do not receive your premium key within 30 minutes, please contact us via email at <b>support@buypremiumkey.com</b>. We are always here to assist you. Thank you very much!</span>
                                                    </p>
                                                    <p style="color: red">Notice*: The product name in your invoice has been changed for security purposes.</p>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div> 
                </div> 
            </div>
        </div> 
    </body>
</html>

<?php
if ($model->payment_status != "completed") {
    header("refresh: 120;");
}
?>

