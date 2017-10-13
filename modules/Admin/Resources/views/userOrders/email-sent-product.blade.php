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
                            <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Buy Premium Key</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                Dear {{ $model_orders->first_name." ".$model_orders->last_name }},
                                <p>This is your product for the invoice # <b>{{ $model_orders->order_no }}</b></p>
                                <p>You can view your order history by going to the
                                    <a href="{{ URL::route('users.getMyAccount') }}">my account</a>
                                    page and by clicking on
                                    <a href="{{ URL::route('users.orderHistory') }}">history</a>. Thanks you for choosing us service. We apologize for any inconvenience this may have caused you.
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
<tr>

<tr>
    <td bgcolor="#ffffff" align="center" style="padding: 15px;" class="padding">
        <!--[if (gte mso 9)|(IE)]>
        <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
            <tr>
                <td align="center" valign="top" width="500">
        <![endif]-->

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"  class="responsive-table">

            <tr>
                <td style="padding: 10px 0 0 0; border-top: 1px dashed #aaaaaa;">
                    <!-- TWO COLUMNS -->
                    <table cellspacing="0" cellpadding="0" border="0" width="100%">
                        <?php foreach ($model_key as $item): ?>
                            <tr>
                                <td valign="top" class="mobile-wrapper">
                                    <!-- LEFT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                        <tr>
                                            <td style="padding: 0 0 10px 0;">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;">
                                                            <p><span style="font-weight: bold">{{ $item->articles_type_title }}</span>: <span style="color: #7ca230">{{ $item->key }}</span></p>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- RIGHT COLUMN -->
                                    <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                        <tr>
                                            <td style="padding: 0 0 10px 0;">
                                                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                    <tr>
                                                        <td align="right" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold">${{ $item->articles_type_price }}</td>
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
                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                    <tr>
                                        <td style="padding: 0 0 10px 0;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px;"><b>Charges ({{$model_orders->payment_type->title}})</b></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!-- RIGHT COLUMN -->
                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                    <tr>
                                        <td style="padding: 0 0 10px 0;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">${{$model_orders->payment_charges}}</td>
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
                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="left">
                                    <tr>
                                        <td style="padding: 0 0 10px 0;">
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td align="left" style="font-family: Arial, sans-serif; color: #333333; font-size: 16px; font-weight: bold;">Total</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!-- RIGHT COLUMN -->
                                <table cellpadding="0" cellspacing="0" border="0" width="47%" style="width: 47%;" align="right">
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                <tr>
                                                    <td align="right" style="font-family: Arial, sans-serif; color: #7ca230; font-size: 16px; font-weight: bold;">${{ $model_orders->total_price }}</td>
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
        <!--[if (gte mso 9)|(IE)]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </td>
</tr>
@stop