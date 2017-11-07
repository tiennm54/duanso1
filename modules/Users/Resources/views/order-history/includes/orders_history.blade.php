<?php if(isset($model_history) && count($model_history) != 0):?>
<h2>Order History</h2>
<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <td class="text-left">Date Added</td>
        <td class="text-center">Status</td>
        <td class="text-center">Comment</td>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($model_history as $item):?>
        <tr>
            <td class="text-left" style="vertical-align: middle"><span class="label label-default">{{ $item->created_at }}</span></td>
            <td class="text-center" style="vertical-align: middle"><span class="label label-primary">{{ $item->history_name }}</span></td>
            <td class="text-center">{{ ($item->comment) ? $item->comment : "N/A" }}</td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php endif;?>