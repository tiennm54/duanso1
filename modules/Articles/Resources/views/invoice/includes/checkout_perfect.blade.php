<p>
    1. Visit website: <a href="https://perfectmoney.is" target="_blank">https://perfectmoney.is</a>
</p>
<p>
    2. Please transfer your money to my wallet: <b>{{ $model->payment_type->payment_id }}</b> ({{$model->payment_type->email}})
</p>
<p>
    3. Set the amount in your order: <b>${{ $model->total_price }}</b>
</p>
<p>
    4.  Set the "Description" <span style="color: red">(You must correct this description)</span>: <b>{{ $model->order_no }}</b>
</p>
<p>
    5. Your keys/vouchers/account will be delivery within 1-6 hours. 
    If you do not receive premium in maximum 8 hours => Please contact us 
</p>
<p>
    6. Your premium key/account will be delivery by email from <b><?php echo EMAIL_BUYPREMIUMKEY ?></b>. Please make sure to check your inbox and Spam(Junk) box to get the key/account.
</p>