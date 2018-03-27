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
                            <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">Buy Premium Key</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                Dear {{ $model_orders->first_name." ".$model_orders->last_name }},
                                <p>
                                    We recently noticed an issue with your account.<br/>
                                    Your account has been lock.<br/>
                                    1. You will not be able to use your bonus money to shop until we have finished processing your issue<br/>
                                    2. You will not receive any bonuses from buying the products of the team members.
                                    Do not worry, you can still shop with other payment methods. Please use another email to purchase your product.<br/>
                                    Thank you so much!
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
    </td>
</tr>

@stop