<div class="row">
    <div class="col-md-4" >
        <?php if(isset($model->getDescription) && $model->getDescription != null):
            foreach ($model->getDescription as $item):?>
            <label>Description: </label>
            <input class="form-control" name="des[]" type="text" placeholder="Description..." value="{{ $item->description }}"/>
        <?php endforeach;
            endif;?>

        <div class="form-group" id="fieldList">
            <label>Specification: </label>
            <input class="form-control" name="des[]" type="text" placeholder="Specification..." />
        </div>

        <div class="form-group">
            <button id="addMore" class="btn btn-primary">Add more fields</button>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#addMore").click(function(e) {
            e.preventDefault();
            $("#fieldList").append("&nbsp;");
            $("#fieldList").append('<input class="form-control" name="des[]" type="text" placeholder="Specification..." />');

        });
    });
</script>