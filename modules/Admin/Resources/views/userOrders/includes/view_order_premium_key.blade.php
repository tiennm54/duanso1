<div class="alert alert-success" style="display: none">

</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>

                <td class="text-left">Product Name</td>
                <td class="text-center" width="50%">Premium key</td>
                <td class="text-center">Status</td>
                <td class="text-center">Date sent</td>
                <td class="text-center">Price</td>
                <td class="text-center">Action</td>

            </tr>
        </thead>
        <?php if (count($model_key) == 0): ?>
            <tbody>
                <tr>
                    <td class="text-left" colspan="6">Your premium key for order is empty!</td>
                </tr>
            </tbody>
        <?php endif; ?>
        <?php if (count($model_key) > 0): ?>
            <?php foreach ($model_key as $item): ?>
                <tbody>
                    <tr>
                        <td class="text-left">{{ $item->articles_type_title }}</td>
                        <td class="text-left">
                            <input class="form-control" value="{{ $item->key }}" id="premium_key{{$item->id}}">
                        </td>
                        <td class="text-center">
                            <span class="label  {{ ($item->status == "active") ? "label-primary" : "label-danger" }}">{{ $item->status }}</span>
                        </td>
                        <td class="text-center">
                            <span class="label  {{ ($item->date_sent) ? "label-primary" : "label-danger" }}">{{ ($item->date_sent) ? $item->date_sent : "None" }}</span>
                        </td>
                        <td class="text-center">
                             <span class="label label-default">${{ $item->articles_type_price }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary" onclick="savePremiumKey({{ $item }})"><i class="fa fa-save"></i></button>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        <?php endif; ?>

        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td class="text-right"><b>Sub-Total</b></td>
                <td class="text-center"><span class="label label-info">${{ $model->sub_total }}</span></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="text-right"><b>Chargers {{ $model->payment_type->title }}</b></td>
                <td class="text-center"><span class="label label-info">${{ $model->payment_charges }}</span></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td class="text-right"><b>Total</b></td>
                <td class="text-center"><span class="label label-danger">${{ $model->total_price }}</span></td>
            </tr>
        </tfoot>

    </table>
</div>

@include('admin::userOrders.includes.js')