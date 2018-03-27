<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td class="text-left">Product Name</td>
            <td class="text-left">Model</td>
            <td class="text-right">Quantity</td>
            <td class="text-right">Unit Price</td>
            <td class="text-right">Total</td>
            <td style="width: 20px;"></td>
        </tr>
        </thead>
        <tbody>
        <?php if (count($model_order) == 0):?>
        <tr>
            <td class="text-left" colspan="6">Your shopping cart is empty!</td>
        </tr>
        <?php endif;?>
        <?php if (count($model_order) > 0):?>
        <?php foreach ($model_order as $item):?>
        <tr>
            <td class="text-left">{{ $item->articles_type->title }}</td>
            <td class="text-left">{{ $item->articles_type->getArticles->title }}</td>
            <td class="text-right">{{ $item->quantity }}</td>
            <td class="text-right">${{ $item->price_order }}</td>
            <td class="text-right">${{ $item->total_price }}</td>

            <td class="text-right" style="white-space: nowrap;">
                <a onclick="addToCart({{ $item->articles_type_id }})" data-toggle="modal" data-target="#myModal"
                   data-toggle="tooltip" title="Reorder" class="btn btn-primary" data-original-title="Reorder">
                    <i class="fa fa-shopping-cart"></i>
                </a>
                {{--<a href="" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Return">
                    <i class="fa fa-reply"></i>
                </a>--}}
            </td>

        </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="3"></td>
            <td class="text-right"><b>Sub-Total</b></td>
            <td class="text-right">${{ $model->sub_total }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="text-right"><b>Chargers {{ $model->payment_type->title }}</b></td>
            <td class="text-right">${{ $model->payment_charges }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="text-right"><b>Used bonus</b></td>
            <td class="text-right">${{ $model->used_bonus }}</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="3"></td>
            <td class="text-right"><b>Total</b></td>
            <td class="text-right">${{ $model->total_price }}</td>
            <td></td>
        </tr>
        </tfoot>

    </table>
</div>