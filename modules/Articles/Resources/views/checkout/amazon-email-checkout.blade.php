@extends('email.master')
@section('content')
<tr>
    <td bgcolor="#ffffff" align="center" style="padding: 15px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
            <tr>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                        <tr>
                            <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">
                                Invoice #{{ $model_orders->order_no }}
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                <p>Dear <span style="font-weight: bold">{{ $model_orders->first_name." ".$model_orders->last_name }}</span><br/>
                                    <span>Your order has been placed! Invoice: #<span style="font-weight: bold;">{{ $model_orders->order_no }}</span></span><br/>
                                    <?php if ($model_orders->total_price == 0) { ?>
                                        <span style="font-weight: bold; color: blue">
                                            This order has been charging on your available balance. 
                                            Please wait us to verify again, then we will send you an email to confirm that your payment is valid. 
                                            If your payment is not valid, transaction will be canceled.
                                        </span><br/>
                                    <?php } ?>
                                </p>
                                <p>
                                    <span>Your account: {{ $model_user->email }}</span><br/>
                                    <?php if ($password != "") { ?>
                                        <span>Password: {{ $password }}</span><br/>
                                        <span>Click <a href="{{ URL::route('users.getChangePassword') }}">here</a> to change your password</span><br/>
                                    <?php } ?>
                                </p>
                                <?php if ($model_orders->total_price > 0) { ?>
                                    <p style="background-color: yellow"><b>Amazon Gift Cards Instructions</b></p>
                                    <ul>
                                        <li>1. Click <a href="https://www.amazon.com/gp/product/B004LLIKVU/">https://www.amazon.com/gp/product/B004LLIKVU/</a></li>
                                        <li>2. Set the amount in your order: <b>${{ $model_orders->total_price }}</b></li>
                                        <li>3. Set the "Recipient E-mail": <b>{{ $model_orders->payment_type->email }}</b></li>
                                        <li>4. Set the "Description": <span style="color: red">(You must correct this message)</span> <br>
                                            <b>{{ $model_orders->order_no }}</b>
                                        </li>
                                        <li>5. Click the "Proceed to checkout" button to pay</li>
                                    </ul>
                                    <a href="https://youtu.be/-yHq2W0BmUQ" style="font-weight: bold">Video : How To Send Amazon E-mail Gift Cards</a>
                                <?php } ?>
                            </td>
                        </tr>

                        <!--LIST PRODUCT--->
                        <tr>
                            <td>
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td align="left" style="font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                            <p style="background-color: yellow"><b>Your Product</b></p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">

                                <!-- TWO COLUMNS -->
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">

                                    <?php foreach ($model_orders->orders_detail as $item): ?>
                                        <tr>
                                            <td valign="top" class="mobile-wrapper">
                                                <!-- LEFT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="left"
                                                                        style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">{{ $item->title }}
                                                                        ({{ $item->quantity }})
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!-- RIGHT COLUMN -->
                                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                       align="right">
                                                    <tr>
                                                        <td style="padding: 0 0 10px 0;">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                <tr>
                                                                    <td align="right"
                                                                        style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                        ${{ $item->total_price }}</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- TWO COLUMNS -->
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                            <!-- LEFT COLUMN -->
                                            <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                   align="left">
                                                <tr>
                                                    <td style="padding: 0 0 10px 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="left"
                                                                    style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                    Charges ({{$model_orders->payment_type->title}})
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- RIGHT COLUMN -->
                                            <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                   align="right">
                                                <tr>
                                                    <td style="padding: 0 0 10px 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="right"
                                                                    style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                    ${{$model_orders->payment_charges}}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!-- TWO COLUMNS -->
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td valign="top" style="padding: 0;" class="mobile-wrapper">
                                            <!-- LEFT COLUMN -->
                                            <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                   align="left">
                                                <tr>
                                                    <td style="padding: 0 0 10px 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="left"
                                                                    style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                    Used bonus
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- RIGHT COLUMN -->
                                            <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                   align="right">
                                                <tr>
                                                    <td style="padding: 0 0 10px 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="right"
                                                                    style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                                    ${{$model_orders->used_bonus}}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0 0px 0; border-top: 1px solid #eaeaea; border-bottom: 1px dashed #aaaaaa;">
                                <!-- TWO COLUMNS -->
                                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                    <tr>
                                        <td valign="top" class="mobile-wrapper">
                                            <!-- LEFT COLUMN -->
                                            <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                   align="left">
                                                <tr>
                                                    <td style="padding: 0 0 10px 0;">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="left"
                                                                    style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">
                                                                    Total
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- RIGHT COLUMN -->
                                            <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;"
                                                   align="right">
                                                <tr>
                                                    <td>
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tr>
                                                                <td align="right"
                                                                    style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">
                                                                    ${{ $model_orders->total_price }}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td bgcolor="#ffffff" align="center" style="padding: 15px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" style="font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                <p>
                                    <b style="color: red">After you have paid successfully, please let us know by replying to this email.</b>
                                </p>
                                <p>
                                    <span>Our working time is: Mon - Sun / 8:00AM - 10:00PM GTM + 7</span><br>
                                    <span>If you pay within this period, you will receive premium key/voucher within 30 minute -> 1 hours.</span><br>
                                    <span>In contrast, you will be received your premium key/voucher within 6->8 hours. We're sorry for the delay in delivery.</span><br>
                                </p>
                                <p>If you do not receive premium in maximum 8 hours, please contact us: <?php echo EMAIL_BUYPREMIUMKEY; ?>. We will check again and send you the premium key/account </p>
                                <p>
                                    <span>You can view your order history by going to the <a href="{{ URL::route('users.getMyAccount') }}">my account</a> page and by clicking on <a href="{{ URL::route('users.orderHistory') }}">history</a>.</span>
                                </p>
                                <p>Thanks you for choosing us service. We apologize for any inconvenience this may have caused you.</p>
                                <p style="font-weight: bold">Thanks in advance, <br/> Reseller Team <?php echo NAME_COMPANY; ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>

@stop