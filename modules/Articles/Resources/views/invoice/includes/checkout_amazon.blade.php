<p>
    1. Click <a href="https://www.amazon.com/gp/product/B004LLIKVU/" target="_blank">https://www.amazon.com/gp/product/B004LLIKVU/</a>
</p>
<p>
    2. Set the amount in your order: <b>${{ $model->total_price }}</b>
</p>
<p>
    3. Set the "Recipient E-mail": <b>{{ $model->payment_type->email }}</b>
</p>
<p>
    4. Set the "Description" (You must correct this message): <b>{{ $model->order_no }}</b>
</p>
<p>
    5. Your keys/vouchers/account will be delivery within 1-6 hours. 
    If you do not receive premium in maximum 8 hours => Please contact us 
</p>
<p>
    6. Your premium key/account will be delivery by email from <b><?php echo EMAIL_BUYPREMIUMKEY?></b>. Please make sure to check your inbox and Spam(Junk) box to get the key/account.
</p>




