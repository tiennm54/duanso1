<div class="col-md-4">
    <div class="col-md-12 well">
        <p class="header-check-out"><i class="glyphicon glyphicon-credit-card"></i> Payment Methods</p>
        <?php foreach ($model_payment_type as $item):?>
            <?php if($item->code == "PAYPAL" && $user_country == "VN" ){
                //Khong hien thi phuong thuc thanh toan paypal doi voi VN
            }else{?>
            <div class="form-group col-md-12">
                <div class="radio">
                    <label>
                        <input type="radio"
                               class="payment-type"
                               value="{{ $item->id }}"
                               name="payments_type_id"
                               <?php if ($item->status_disable == 1){ echo "disabled"; } ?>
                               <?php if ($item->status_selected == 1){ echo "checked='checked'"; } ?>
                               onclick="selectTypePayment({{ $item }})"/>
                        <img src="{{url('images/'.$item->image)}}" alt="{{ $item->title }}" style="width: 80px"/>
                        <span style="font-weight: bold">
                            {{ $item->title }} 
                            <?php if($item->code == "BONUS"){ echo "(".$money_user."$)"; }?>
                        </span>
                    </label>
                </div>
            </div>
            <?php } ?>
        <?php endforeach; ?>
    </div>
</div>