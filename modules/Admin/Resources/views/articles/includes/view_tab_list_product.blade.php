<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <h2><?php echo $model->title?></h2>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Price Reseller</th>
                <th>Price</th>
                <th>Old Price</th>
                <th>Status Stock</th>
                <th>Status Show/Hide</th>
                <th width="20%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($model_children) != 0) { ?>
                <?php foreach ($model_children as $key => $item): ?>
                <form method="post" action="<?php echo URL::route('articlesChildren.savePriceStatus', ['id' => $item->id]); ?>">
                    <tr>
                        <td><?php echo $item->title; ?></td>
                        <td width="10px">
                            <input name="price_reseller" value="<?php echo (($item->price_reseller) ? $item->price_reseller : "0"); ?>"/>
                        </td>
                        <td>
                             <input name="price_order" value=" <?php echo $item->price_order; ?>"/>
                        </td>
                        <td>
                            <input name="old_price" value="<?php echo $item->old_price; ?>"/>
                        </td>
                        <td>
                            <select name="status_stock">
                                <option value="1" <?php echo ($item->status_stock == 1) ? "selected" : ""; ?>>In Stock</option>
                                <option value="0" <?php echo ($item->status_stock == 0) ? "selected" : ""; ?>>Not Stock</option>
                            </select>
                        </td>
                        <td>
                            <select name="status_show">
                                <option value="show" <?php echo ($item->status_show != "hide") ? "selected" : ""; ?>>Show</option>
                                <option value="hide" <?php echo ($item->status_show == "hide") ? "selected" : ""; ?>>Hide</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-primary" data-toggle="confirmation">
                                <i class="fa fa-save"></i>
                            </button>
                            <a href="<?php echo URL::route('articlesChildren.getEdit', ['id' => $item->id, 'url' => $item->url_title . '.html']); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                            <a href="<?php echo $item->getUrl(); ?>" target="_blank" class="btn btn-primary"> 
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="<?php echo URL::route('articlesChildren.delete', $item->id); ?>" class="btn btn-danger" data-toggle="confirmation">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                </form>
            <?php endforeach; ?>
        <?php } ?>
        </tbody>
    </table>
</div>
