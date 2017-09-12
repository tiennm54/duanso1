<div class="col-md-4">
    <div class="col-md-12 well">
        <p class="header-check-out"><i class="glyphicon glyphicon-shopping-cart"></i> Review order</p>
        <div class="form-group">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Product name</th>
                    <th width="10%">Quantity</th>
                    <th>Price</th>
                </tr>
                </thead>
                <tbody id="list-product-checkout">

                <?php if ($data == null):?>
                <tr>
                    <td colspan="3">
                        <span>Your shopping cart is empty!</span>
                        <a class="btn btn-primary btn-xs pull-right" href="{{ URL::route('frontend.articles.index') }}">Continue</a>
                    </td>
                </tr>
                <?php endif; ?>

                <?php foreach ($data as $item):?>

                <tr>
                    <td>{{ $item["title"] }}</td>
                    <td align="center">
                        <input type="number" id="quantityProduct<?php echo $item['id'];?>" onchange="changeQuantity(<?php echo $item['id']; ?>)" class="form-control" value="{{ $item["quantity"] }}" style="width: 70%;" min="1">
                    </td>
                    <td align="center">
                        <p>${{ $item["total"] }}</p>
                        <a class="btn btn-danger" onclick="deleteProductCheckout(<?php echo $item['id']; ?>)"><i class="glyphicon glyphicon-trash"></i></a>
                    </td>
                </tr>

                <?php endforeach;?>

                </tbody>
            </table>

        </div>

        <div class="form-group">

            <table class="table table-bordered">

                <tbody>
                <tr>
                    <td>Sub-Total: </td>
                    <td align="center">$<span id="sub-total">{{ $subTotal }}</span></td>
                    <input name="sub_total" value="{{ $subTotal }}" hidden/>
                </tr>
                <tr>
                    <td>Charges <span id="text_payment_selected">{{ $model_payment_selected->title }}</span>: </td>
                    <td align="center">$<span id="payment_charges">{{ $payment_charges }}</span></td>
                    <input name="payment_charges" value="{{ $payment_charges }}" hidden/>
                </tr>
                <tr>
                    <td>Total: </td>
                    <td align="center">$<span id="total">{{ $total }}</span></td>
                    <input name="total_price" value="{{ $total }}" hidden/>
                </tr>
                </tbody>
            </table>


            <label class="checkbox-inline">
                <input type="checkbox" value="1" required name="check_term">
                <a style="color: black; cursor: pointer" data-toggle="modal" data-target="#termsConditions">I've read and agree the Terms and Conditions</a>
            </label>

            <button type="submit" class="btn btn-primary pull-right" id="confirm_order" style="margin-top: 20px"
                    data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Confirm Order</button>

        </div>

    </div>
</div>