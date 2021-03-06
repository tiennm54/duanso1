<div class="col-md-4">
    <div class="col-md-12 well">
        <p class="header-check-out"><i class="glyphicon glyphicon-credit-card"></i> Payment Methods</p>
        <?php foreach ($model_payment_type as $item):?>


        <div class="form-group col-md-12">
            <div class="radio">
                <label>
                    <input type="radio"
                           class="payment-type"
                           value="{{ $item->id }}"
                           name="payments_type_id"
                           <?php if ($item->status_disable == 1){ echo "disabled"; } ?>
                           <?php if ($item->status_selected == 1){ echo "checked='checked'"; } ?>
                           onclick="selectTypePayment({{ $item }})"
                    />
                    <img src="{{url('images/'.$item->image)}}" alt="{{ $item->title }}" style="width: 80px"/>
                    <span style="font-weight: bold">{{ $item->title }}</span>
                    <p style="margin-top: 5px">
                        <span>Charges: </span>
                        <span>{{ $item->fees}}</span><span>%</span>
                        <span>+</span>
                        <span>$</span><span>{{ $item->plus }}</span>
                    </p>

                </label>
            </div>

        </div>
        <?php endforeach; ?>
    </div>
</div>