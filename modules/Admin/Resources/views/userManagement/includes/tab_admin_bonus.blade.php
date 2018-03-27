<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            Total Bonus: {{ ($model->getMoneyBonus()) ? $model->getMoneyBonus() : 0 }}$
        </h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <td>Buyer</td>
                    <td>Order</td>
                    <td>Price</td>
                    <td>Percent</td>
                    <td>Bonus</td>
                    <td>Type</td>
                    <td>Created at</td>
                </tr>
            </thead>
            <tbody>
                <?php if (count($model_bonus) == 0): ?>
                    <tr>
                        <td colspan="7">You have not received a bonus yet.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($model_bonus as $key => $bonus): ?>
                    <tr>
                        <td style="vertical-align: middle">{{ $bonus->getUserBuy->email }}</td>
                        <td style="vertical-align: middle">
                            <a class="label label-primary" target="_blank" href="{{ URL::route('adminUserOrders.viewOrders', ["id" => $bonus->getOrder->id ]) }}">
                                {{ $bonus->getOrder->order_no }}
                            </a>
                        </td>
                        <td style="vertical-align: middle">{{ $bonus->getOrder->sub_total }}$</td>
                        <td style="vertical-align: middle">{{ $bonus->bonus_percent }}%</td>
                        <td style="vertical-align: middle"><span class="label label-primary">{{ $bonus->bonus }}$</span></td>
                        <td style="vertical-align: middle"><span class="label label-primary">Bonus for {{ $bonus->bonus_type }}</span></td>
                        <td style="vertical-align: middle">{{ $bonus->created_at }}</td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>
{!! $model_bonus->render() !!}