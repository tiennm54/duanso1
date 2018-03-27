<h3>Order History</h3>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <td class="text-center">Date Added</td>
                <td class="text-center">Status</td>
                <td class="text-center">Comment</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($model_history as $item): ?>
                <tr>
            <form method="post" action="{{ URL::route('adminUserOrders.saveHistory',['id'=>$item->id] ) }}">
                <td class="text-center">{{ $item->created_at }}</td>
                <td class="text-center">{{ $item->history_name }}</td>
                <td class="text-center"><textarea cols="50" name="history_comment">{{ $item->comment }}</textarea></td>
                <td class="text-center">
                    <button class="btn btn-primary">Save</button>
                </td>
            </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>