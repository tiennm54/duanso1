<div class="row">
    <div class="col-md-4" >
        <div class="form-group" id="fieldList">
            <label>Specification: </label>
            <input class="form-control" name="des[]" type="text" placeholder="Specification..." />
        </div>

        <div class="form-group">
            <button id="addMore" class="btn btn-primary">Add more fields</button>
        </div>
    </div>

    <div class="col-md-4">
        <button id="clone-specification" class="btn btn-primary">Clone Specification</button>
    </div>
</div>

<script>
    $(function () {
        $("#addMore").click(function (e) {
            e.preventDefault();
            $("#fieldList").append("&nbsp;");
            $("#fieldList").append('<input class="form-control" name="des[]" type="text" placeholder="Specification..." />');

        });
    });

    function cloneSpecification(id) {
//        var token = $("#_token").val();
//        $.ajax({
//            type: 'POST',
//            url: "<?php echo URL::route('frontend.shoppingCart.addToCart') ?>",
//            data: {"product_id": id, "_token": token},
//            success: function (data) {
//                $("#list_order").html(data);
//            },
//            error: function (ex) {
//
//            }
//        });
    }
</script>