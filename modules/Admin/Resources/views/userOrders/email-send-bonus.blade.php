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
                                    Bonus for customers.
                                </td>
                            </tr>
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    <p>Dear {{ $model_user->first_name." ".$model_user->last_name }},</p>
                                    <p>
                                        <span>You received a bonus from order #<?php echo $model_orders->order_no; ?></span><br/>
                                        <span>The bonus you get is: $<?php echo $money; ?></span><br/>
                                        <span>You can view your bonus by going to the
                                        <a href="{{ URL::route('users.getMyAccount') }}">my account</a> page</span>
                                    </p>
                                    <p>
                                        <span>
                                            When your friends register via the link you shared and buy premium key,  you will receive 2% of the total value of the order, and your friend will also receive 2% of the value of the order. 
                                            This amount will be stored in your account, you can use it to buy any products on our website. 
                                            If you are a normal buyer, you will still receive 1% bonus from us.
                                        </span><br>
                                        <span>Thank you for using our service.</span><br>
                                        <span><b>Best Regards</b></span><br/>
                                        <span>BuyPremiumKey.Com Reseller</span>
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