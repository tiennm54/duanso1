<div class="col-md-4">
    <div class="col-md-12 well">
        <p class="header-check-out"><i class="glyphicon glyphicon-credit-card"></i> Payment Methods</p>
        
        <?php foreach ($model_payment_type as $item):?>
            
            <?php
                //check danh sach quoc gia bi chan
                $check_country = false;
                $list_country_disable = $item->disable_country;
                if($list_country_disable != "" && $user_country != ""){
                    $check_country = strpos($list_country_disable, $user_country);
                }
            ?>
        
            <?php
                if($checkPaypalView == false && $checkFilextrasTrue == true && $item->id == 3 && $item->status_disable != 1){// dành cho riêng FilexTras.com
                ?>
                    <div id="payments_type_<?php echo $item->id;?>" class="form-group col-md-12">
                        <div class="radio">
                            <label>
                                <input type="radio"
                                       class="payment-type"
                                       value="{{ $item->id }}"
                                       name="payments_type_id"
                                       id="payments_type_id_<?php echo $item->id; ?>"
                                       <?php //if ($item->status_disable == 1){ echo "disabled"; } ?>
                                       <?php if ($item->status_selected == 1){ echo "checked='checked'"; } ?>
                                       onclick="selectTypePayment({{ $item->id }})"/>
                                <img src="{{url('images/'.$item->image)}}" alt="{{ $item->title }}" style="width: 120px"/>
                                <span style="font-weight: bold">
                                    {{ $item->title }} 
                                    <?php if($item->code == "BONUS"){ echo "(".$money_user."$)"; }?>
                                </span>
                            </label>
                        </div>
                    </div>
            <?php
                }else{// else 1
            ?>
           
            <?php 
            
            if($checkPaypalView == true || $item->status_disable == 1 || ($check_country !== false && $item->disable_vn == 1) || ($item->check_proxy == 1 && $isProxy == "YES")){
                //$isProxy su dung de check IPS Paypal, ngan chan Paypal vao website theo doi
                //Khong hien thi phuong thuc thanh toan paypal doi voi VN
            }else{?>
            <div id="payments_type_<?php echo $item->id;?>" class="form-group col-md-12">
                <div class="radio">
                    <label>
                        <input type="radio"
                               class="payment-type"
                               value="{{ $item->id }}"
                               name="payments_type_id"
                               id="payments_type_id_<?php echo $item->id; ?>"
                               <?php //if ($item->status_disable == 1){ echo "disabled"; } ?>
                               <?php if ($item->status_selected == 1){ echo "checked='checked'"; } ?>
                               onclick="selectTypePayment({{ $item->id }})"/>
                        <img src="{{url('images/'.$item->image)}}" alt="{{ $item->title }}" style="width: 120px"/>
                        <span style="font-weight: bold">
                            {{ $item->title }} 
                            <?php if($item->code == "BONUS"){ echo "(".$money_user."$)"; }?>
                        </span>
                    </label>
                </div>
            </div>
            <?php }
                }// end else 1
            ?>
        <?php endforeach; ?>
    </div>
</div>
