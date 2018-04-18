<script>
    var count_save = 0;
    function savePremiumKey(item) {
        if (confirm("Are you sure you want to save this item?")) {
            var key = $("#premium_key" + item.id).val();

            $.ajax({
                type: 'POST',
                url: "<?php echo URL::route('adminUserOrders.savePremiumKey') ?>",
                data: {"id": item.id, "key": key},
                success: function (data) {
                    if (data == 1 || data == 2) {
                        count_save++;
                        $(".alert").show();
                        $(".alert").removeClass("alert-warning");
                        $(".alert").addClass("alert-success");
                        $(".alert").html("Success! Save premium key: " + item.articles_type_title + " complete (" + count_save + ") !!!")
                        if (data == 1) {
                            document.getElementById("btn-send-key").disabled = false;
                        } else {
                            document.getElementById("btn-send-key").disabled = true;
                        }
                    } else {
                        $(".alert").show();
                        $(".alert").removeClass("alert-success");
                        $(".alert").addClass("alert-warning")
                        $(".alert").html("Warning! Save premium key error !!!");
                    }
                },
                error: function (ex) {
                    alert(ex.responseJSON);
                }
            });
        }
    }
</script>