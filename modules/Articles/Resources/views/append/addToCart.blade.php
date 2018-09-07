<?php if (count($data_product) == 0): ?>

    <tr>
        <td colspan="5">
            Your shopping cart is empty!
        </td>
    </tr>

<?php endif; ?>

<?php foreach ($data_product as $item): ?>

    <tr>
        <td>
            <img src="{{ $item["image"] }}" style="width: 70%">
        </td>
        <td>
            {{ $item["title"] }}
        </td>
        <td>
            <input type="number" class="form-control" value="{{ $item["quantity"] }}" min="1" id="numberProductOrder<?php echo $item['id']; ?>" onchange="changeNumberProductOrder(<?php echo $item['id']; ?>)">
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

<script>
    //Hàm thực hiện để tính tổng số tiền cần thanh toán cho các sản phẩm
    $(document).ready(function(){
        $("#sub-total-order").html("$" + "{{ $subTotal }}");
        $("#quantity_item").html({{ $quantityItem }});
        $("#sub-total-popup").html("$" + "{{ $subTotal }}");
    });
</script>
