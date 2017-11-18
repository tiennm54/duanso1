@extends('email.master')
@section('content')
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 15px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 500px;" class="responsive-table">
                <tr>
                    <td>
                        <!-- COPY -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">Contact By Customer</td>
                            </tr>
                            <tr>
                                <td align="left" style="font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                    <p>Customer: {{ $user["name"] }}</p>
                                    <p>Email: {{ $user["email"] }}</p>
                                    <p>Enquiry: {{ $user["enquiry"] }}</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
@stop