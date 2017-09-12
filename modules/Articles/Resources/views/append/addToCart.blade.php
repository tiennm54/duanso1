<?php if (count($data_product) == 0):?>

<tr>
    <td colspan="5">
        Your shopping cart is empty!
    </td>
</tr>

<?php endif;?>

<?php foreach ($data_product as $item): ?>

<tr>
    <td>
        <img src="{{ $item["image"] }}" style="width: 70%">
    </td>
    <td>
        {{ $item["title"] }}
    </td>
    <td>
        <input type="number" class="form-control" value="{{ $item["quantity"] }}" min="1" id="numberProductOrder<?php echo $item['id'];?>" onchange="changeNumberProductOrder(<?php echo $item['id']; ?>)">
    </td>
    <td align="center">
        <p>${{ $item["total"] }}</p>
    </td>
    <td align="center">
        <a class="btn btn-danger" onclick="deleteSessionOrder({{ $item["id"] }})">
            <i class="glyphicon glyphicon-trash"></i>
        </a>
    </td>
</tr>;

<?php endforeach; ?>

<script type="text/javascript">
    //Hàm thực hiện để tính tổng số tiền cần thanh toán cho các sản phẩm
    $(document).ready(function(){
        $("#sub-total-order").html("$"+"{{ $subTotal }}");
        $("#quantity_item").html({{ $quantityItem }});

        $("#sub-total-popup").html("$"+"{{ $subTotal }}");

    });

    //Hàm thực hiện khi thay đổi số lượng sản phẩm trên popup order
    function changeNumberProductOrder(id) {
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
