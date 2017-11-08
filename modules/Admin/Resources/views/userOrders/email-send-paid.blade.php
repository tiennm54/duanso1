@extends('email.master')
@section('content')
<tr>
    <td bgcolor="#ffffff" align="center" style="padding: 15px;">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
                <td align="center" valign="top" width="500">
        <![endif]-->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" class="responsive-table">
            <tr>
                <td>
                    <!-- COPY -->
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">Buy Premium Key</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                Dear {{ $model_orders->first_name." ".$model_orders->last_name }},

                                <p>
                                    We already received your payment. You will be received your premium key/account within 6->8 hours.
                                    We're sorry for the delay in delivery.
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
                                    <b>Best Regards</b>
                                    <p>Support Team BuyPremiumKey.Com</p>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </td>
</tr>

@stop