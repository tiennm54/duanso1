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
                            <td align="center" style="font-size: 32px; font-family: Helvetica, Arial, sans-serif; color: #333333;" class="padding-copy">BuyPremiumKey.Com Reseller</td>
                        </tr>
                        <tr>
                            <td align="left" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                                <p>
                                    <span>Dear {{ $model_comment->email }},</span><br>
                                    <span>Your comment has been replied!</span>
                                </p>
                                <p>
                                    <span>News title: <a href="<?php echo $model_news->getUrl(); ?>"><?php echo $model_news->title; ?></a></span><br/>
                                    <span>Your comment: <?php echo $model_comment->comment; ?></span><br/>
                                    <span>Email reply: <?php echo $model_reply->email; ?></span><br/>
                                    <span>Reply: <?php echo $model_reply->comment; ?></span><br/>
                                    <span>Date reply: <?php echo $model_reply->created_at; ?></span><br/>
                                    <span>Please see details <a href="<?php echo $model_news->getUrl(); ?>">here</a></span>
                                </p>
                                <p>
                                    <b>Best Regards</b>
                                <p>Team BuyPremiumKey.Com</p>
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