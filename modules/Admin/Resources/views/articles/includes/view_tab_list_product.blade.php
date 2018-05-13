<div class="table-responsive">
    <form method="GET"  action="">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Code</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Status Stock</th>
                <th width="15%">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($model_children) != 0){?>
            <?php foreach($model_children as $key=>$item):?>

            <tr>
                <td><img src="<?php echo url('images/'.$model->image); ?>" width="100px"></td>
                <td><?php echo $item->title;?></td>
                <td><?php echo $item->code;?></td>
                <td><?php echo $model->brand;?></td>
                <td><?php echo $item->price_order."$";?></td>
                <td><?php
                    switch ($item->status_stock){
                        case 1: echo "In Stock"; break;
                        case 0: echo "Not In Stock"; break;
                    }
                    ?></td>
                <td>
                    <a href="<?php echo URL::route('articlesChildren.getEdit', ['id' => $item->id, 'url' => $item->url_title.'.html' ]); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                    <a  href="<?php echo $item->getUrl(); ?>" target="_blank" class="btn btn-primary"> <i class="fa fa-eye"></i></a>
                    <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo URL::route('articlesChildren.delete', $item->id); ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                </td>
            </tr>

            <?php endforeach; ?>
            <?php } ?>

            </tbody>
        </table>
    </form>
</div>
