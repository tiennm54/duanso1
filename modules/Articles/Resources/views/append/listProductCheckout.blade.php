

<?php if ($data_product == null):?>
    <tr>
        <td colspan="3">
            <span>Your shopping cart is empty!</span>
            <a class="btn btn-primary btn-xs pull-right" href="{{ URL::route('frontend.articles.index') }}">Continue</a>
        </td>
    </tr>
<?php endif; ?>

<?php foreach ($data_product as $item):?>

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


<script>
    //Hàm thực hiện để tính tổng số tiền cần thanh toán cho các sản phẩm
    $(document).ready(function(){
        var quantity = "<?php echo Session::get('quantity_item'); ?>";
        $("#sub-total-order").html("$"+"{{ $subTotal }}");
        $("#quantity_item").html(quantity);
        $("#sub-total-popup").html("$"+"{{ $subTotal }}");

        $("#sub-total").html({{ $subTotal }});
        $("#payment_charges").html({{ $payment_charges }});
        $("#total").html({{ $total }});

    });
</script>
