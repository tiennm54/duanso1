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
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">Buy Premium Key</td>
                            </tr>
                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    Dear {{ $user->first_name }} {{ $user->last_name }},
                                </td>
                            </tr>

                            <tr>
                                <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">

                                    <p>There was recently a request to change the password for your account.</p>

                                    <p>If you requested this password change, please click on the following link to reset your password:</p>

                                    <a href="{{ URL::route('users.getResetPassword',['user_email'=>$user->email, "key_forgotten" => $user->key_forgotten]) }}">
                                        {{ URL::route('users.getResetPassword',['user_email'=>$user->email, "key_forgotten" => $user->key_forgotten]) }}
                                    </a>

                                    <p>If clicking the link does not work, please copy and paste the URL into your browser instead.</p>

                                    <p>If you did not make this request, you can ignore this message and your password will remain the same.</p>

                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@stop