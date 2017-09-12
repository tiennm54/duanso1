@extends('email.master')
@section('content')
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellspacing="0" cellpadding="0" width="500">
                <tr>
                    <td align="center" valign="top" width="500">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Your contact</td>
                            </tr>

                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    Dear {{ $user["name"] }},
                                </td>
                            </tr>

                            <tr>

                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    <p>This is your contact has been sent to us</p>
                                    <p>User name: {{ $user["name"] }}</p>
                                    <p>Email: {{ $user["email"] }}</p>
                                    <p>Enquiry: {{ $user["enquiry"] }}</p>
                                    <p>We will get back to you in the shortest time possible</p>
                                    <p>Regards</p>
                                    <p>Admin buypremium.com</p>

                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@stop