<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Spending by bonus money: {{ ($data["total_spending"]) ? $data["total_spending"] : "0" }}$
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <td>Order</td>
                    <td>Sub total</td>
                    <td>Charges</td>
                    <td>Total price</td>
                    <td>Created at</td>
                </tr>
            </thead>
            <tbody>
                <?php if (count($model_spending) == 0): ?>
                    <tr>
                        <td colspan="5">You have no order is successfully transacted by bonus money.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($model_spending as $key => $spending): ?>
                    <tr>
                        <td style="vertical-align: middle"><span class="label label-primary">{{ $spending->getUserOrder->order_no }}</span></td>
                        <td style="vertical-align: middle">{{ $spending->getUserOrder->sub_total }}$</td>
                        <td style="vertical-align: middle">{{ $spending->getUserOrder->payment_charges }}%</td>
                        <td style="vertical-align: middle"><span class="label label-primary">{{ $spending->getUserOrder->total_price }}$</span></td>
                        <td style="vertical-align: middle">{{ $spending->created_at }}</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
{!! $model_spending->render() !!}