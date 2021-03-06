@extends('email.master')
@section('content')
<tr>
    <td bgcolor="#ffffff" align="center" style="padding: 15px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;"
               class="responsive-table">
            <tr>
                <td>
                    <!-- COPY -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center"
                                style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;"
                                class="padding-copy">Invoice #{{ $model_orders->order_no }}
                            </td>
                        </tr>
                        <tr>
                            <td align="left"
                                style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                <p>Dear <span style="font-weight: bold">{{ $model_orders->first_name." ".$model_orders->last_name }}</span></p>
                                Your order has been placed! Orders: #<span style="font-weight: bold; color: #0000cc">{{ $model_orders->order_no }}</span><br/>
                                You can view your order history by going to the <a href="{{ URL::route('users.getMyAccount') }}">my account</a> page and by clicking on <a href="{{ URL::route('users.orderHistory') }}">history</a>.<br/>
                                <p>Your account: {{ $model_user->email }}</p>
                                <?php if ($password != "") { ?>
                                    <p>Password: {{ $password }}</p>
                                    <p>Click <a href="{{ URL::route('users.getChangePassword') }}">here</a> to change your password</p>
                                <?php } ?>
                                <p style="background-color: yellow"><b>Notice: please read carefully before you make the payment</b></p>
                                <ul>
                                    <li>1. Please DO NOT write any things on MESSAGE BOX (We will cancel your payment if you write any things)</li>
                                    <li>2. Your keys/vouchers/account will be delivery within 2-6 hours. If you can not wait, please do not make the payment.</li>
                                    <li>3. If you do not receive premium in maximum 12 hours => Please contact us first, do not open the disputed!</li>
                                    <li>4. Your premium key/account will be deilivery by email from <?php echo EMAIL_BUYPREMIUMKEY; ?>. Please make sure to check your Inbox and Spam(Junk) box to get the key/account.</li>
                                </ul>
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
                                <?php
                                    $url_checkout = "https://www.paypal.com/cgi-bin/webscr?business=". $model_orders->payment_type->email ."&cmd=_xclick&currency_code=USD&amount=" . $model_orders->total_price . "&item_name=Design-Logo-" . $model_orders->order_no;
                                ?>
                                <p style="background-color: yellow"><b>Check out with Paypal</b></p>
                                <p>
                                    <a href="{{ $url_checkout }}" target="_blank">
                                        <img alt="Buy premium key com" src="{{url('theme_frontend/image/checkout-paypal.png')}}" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 16px;" border="0">
                                    </a>
                                </p>
                                <p>If you do not receive premium in maximum 6 hours, please contact us: <?php echo EMAIL_BUYPREMIUMKEY; ?>. We will check again and send you the premium key/account </p>
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