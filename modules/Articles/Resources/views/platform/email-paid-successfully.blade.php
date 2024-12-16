@extends('email.master')
@section('content')
<tr>
    <td bgcolor="#ffffff" align="center" style="padding: 15px;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" class="responsive-table">
            <tr>
                <td>
                    <!-- COPY -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">
                                You have successfully paid $<?php echo $model_orders->total_price; ?> USD
                            </td>
                        </tr>
                        <tr>
                            <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                Dear {{ $model_orders->first_name." ".$model_orders->last_name }},

                                <p>
                                    <span style="font-weight: bold">We have received your payment for order #{{ $model_orders->id }}.</span>
                                </p>
                                
                                <p>
                                    <span>1. If you do not receive premium voucher/account by email within 2 hours => Please contact us: <?php echo EMAIL_BUYPREMIUMKEY; ?>. We will check again and re-send premium voucher to you.</span><br>
                                    <span>2. You can check your premium key/order status here: <a href="{{ URL::route('users.orderHistoryView', ["id" => $model_orders->id , "order_no" => $model_orders->order_no ]) }}">CHECK YOUR PREMIUM KEY</a></span><br>
                                    <span>3. Please <span style="color: red">DO NOT OPEN DISPUTE</span> in any case, we are always here to assist you!</span><br>
                                    <span>4. If you cannot find the product in your inbox, please check your spam mailbox. Thank you!</span><br>
                                    <span>5. If you have any problems, just contact us: <?php echo EMAIL_BUYPREMIUMKEY; ?></span><br>
                                </p>

                                <p>
                                    You can view your order history by going to the
                                    <a href="{{ URL::route('users.getMyAccount') }}">my account</a>
                                    page and by clicking on
                                    <a href="{{ URL::route('users.orderHistory') }}">history</a>. 
                                    Thanks you for choosing us service. 
                                    We apologize for any inconvenience this may have caused you.
                                </p>

                                <p>
                                    <span style="font-weight: bold">Thanks in advance, Best Regards</span><br>
                                    <span>Support Team BuyPremiumKey.Com</spans>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </td>
</tr>

@stop