<div class="col-md-4">
    <div class="col-md-12 well">
        <p class="header-check-out"><i class="glyphicon glyphicon-shopping-cart"></i> Review order</p>
        <div class="form-group">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th width="10%">Quantity</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody id="list-product-checkout">

                    <?php if ($data == null): ?>
                        <tr>
                            <td colspan="3">
                                <span>Your shopping cart is empty!</span>
                                <a class="btn btn-primary btn-xs pull-right" href="{{ URL::route('frontend.articles.index') }}">Continue</a>
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($data as $item): ?>
                        <tr>
                            <td>{{ $item["title"] }}</td>
                            <td align="center">
                                <input type="number" id="quantityProduct<?php echo $item['id']; ?>" onchange="changeQuantity(<?php echo $item['id']; ?>)" class="form-control" value="{{ $item["quantity"] }}" style="width: 70%;" min="1">
                            </td>
                            <td align="center">
                                <p>${{ $item["price_order"] }}</p>
                                <a class="btn btn-danger" onclick="deleteProductCheckout(<?php echo $item['id']; ?>)"><i class="glyphicon glyphicon-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <tfoot>
                    <tr>
                        <td colspan="2" align="right">Sub-Total </td>
                        <td align="center">$<span id="sub-total">{{ $totalOrder['sub_total'] }}</span></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">Charges <span id="text_payment_selected">{{ $totalOrder['payment_name'] }}</span> </td>
                        <td align="center">$<span id="payment_charges">{{ $totalOrder['charges'] }}</span></td>
                    </tr>
                    <?php if (Auth::check()) { ?>
                    <tr id="tr-use-bonus">
                        <td colspan="2" align="right">Use my bonus ({{ $money_user }}$)</td>
                        <td align="center">
                            <input type="checkbox" value="{{ $money_user }}" name="use_my_bonus" id="cb-my-bonus" onclick="chooseBonusMoney()">
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" align="right">Total </td>
                        <td align="center">$<span id="total">{{ $totalOrder['total'] }}</span></td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <label class="checkbox-inline">
                <input type="checkbox" value="1" name="check_term" id="cb-terms" required checked>
                <a style="color: black; cursor: pointer" data-toggle="modal" data-target="#termsConditions">I've read and agree the Terms and Conditions</a><br>
                {!! $errors->first('check_term','<span class="control-label color-red" style="color: red">*:message</span>') !!}
            </label>

            <a onclick="saveOrder()" 
               class="btn btn-success pull-right" 
               id="confirm_order" 
               style="margin-top: 20px"
               data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">
                Confirm Order
            </a>

        </div>
    </div>
</div>

@include('articles::modal.termsConditions')