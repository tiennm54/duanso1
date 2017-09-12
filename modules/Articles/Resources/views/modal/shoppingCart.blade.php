<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Shopping Cart</h4>
            </div>
            <div class="modal-body"  style="overflow: auto">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 25%">Image</th>
                        <th>Product name</th>
                        <th align="center">Quantity</th>
                        <th align="center">Price</th>
                        <th align="center">Action</th>
                    </tr>
                    </thead>
                    <tbody id="list_order">
                    <!--CONTENT LIST ORDER CỦA MODAL-->
                    </tbody>
                </table>
                <span style="font-weight: bolder">Total: <span id="sub-total-popup">$00.00</span></span>
            </div>

            <div class="modal-footer">
                <a href="{{ URL::route('frontend.checkout.index') }}" type="button" class="btn btn-primary">Checkout</a>
                <a href="{{ URL::route('frontend.articles.index') }}" type="button" class="btn btn-primary pull-left">Continue shopping</a>
            </div>
        </div>

    </div>
</div>