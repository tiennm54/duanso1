<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Spending by bonus money: {{ ($model->getSpendingMoney()) ? $model->getSpendingMoney() : 0 }}$
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <td>Order</td>
                    <td>Sub total</td>
                    <td>Charges</td>
                    <td>Spending</td>
                    <td>Total price</td>
                    <td>Created at</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                <?php if (count($model_spending) == 0): ?>
                    <tr>
                        <td colspan="7">You have no order is successfully transacted by bonus money.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($model_spending as $key => $spending): ?>
                    <tr>
                        <td style="vertical-align: middle">
                            <a href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $spending->getUserOrder->id ]) }}" target="_blank">
                                <span class="label label-primary">{{ $spending->getUserOrder->order_no }}</span>
                            </a>
                        </td>
                        <td style="vertical-align: middle">{{ $spending->getUserOrder->sub_total }}$</td>
                        <td style="vertical-align: middle">{{ $spending->getUserOrder->payment_charges }}$</td>
                        <td style="vertical-align: middle"><span class="label label-primary">{{ $spending->total_payment }}$</span></td>
                        <td style="vertical-align: middle">{{ $spending->getUserOrder->total_price }}$</td>
                        <td style="vertical-align: middle">{{ $spending->created_at }}</td>
                        <td> 
                            <a href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $spending->getUserOrder->id]) }}" target="_blank" data-toggle="tooltip" title="View Order" class="btn btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
{!! $model_spending->render() !!}