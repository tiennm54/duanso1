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
                <a href="{{ URL::route('frontend.checkout.index') }}" type="button" class="btn btn-success">Checkout</a>
                <a href="{{ URL::route('frontend.articles.index') }}" type="button" class="btn btn-primary pull-left">Continue shopping</a>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    //Hàm thực hiện khi thay đổi số lượng sản phẩm trên popup order
    function changeNumberProductOrder(id) {
        console.log("Change Number Product Order");
        var number = $("#numberProductOrder"+id).val();
        if (number <= 0){
            number = 1;
            $("#numberProductOrder"+id).val(1);
        }

        var token = $("#_token").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo URL::route('frontend.shoppingCart.changeNumberProductOrder') ?>",
            data: {"id" : id, "number" : number, "_token" : token},
            success: function (data) {
                $("#list_order").html(data);
            },
            error: function (ex) {

            }
        });
    }

    function deleteSessionOrder(item) {
        console.log("Delete Session Order");
        if (confirm("Are you sure you want to delete this item?")) {
            var token = $("#_token").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('frontend.shoppingCart.deleteSessionOrder') ?>",
                data: {"id": item, "_token": token},
                success: function (data) {
                    $("#list_order").html(data);
                },
                error: function (ex) {

                }
            });
        }
    }
</script>