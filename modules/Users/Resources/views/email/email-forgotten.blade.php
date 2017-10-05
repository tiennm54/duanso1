@extends('email.master')
@section('content')
    <tr>
        <td bgcolor="#ffffff" align="center">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" style="font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    <p>Dear <span style="font-weight: bold">{{ $user->first_name }} {{ $user->last_name }}</span>,</p>
                                    <p>There was recently a request to change the password for your account.</p>
                                    <p>If you requested this password change, please click on the following link to reset your password:</p>
                                    <a href="{{ URL::route('users.getResetPassword',['user_email'=>$user->email, "key_forgotten" => $user->key_forgotten]) }}">
                                        {{ URL::route('users.getResetPassword',['user_email'=>$user->email, "key_forgotten" => $user->key_forgotten]) }}
                                    </a>
                                    <p>If clicking the link does not work, please copy and paste the URL into your browser instead.</p>
                                    <p>If you did not make this request, you can ignore this message and your password will remain the same.</p>
                                    <b>Thank you so much!</b>
                                    <p>Buy Premium Key</p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@stop