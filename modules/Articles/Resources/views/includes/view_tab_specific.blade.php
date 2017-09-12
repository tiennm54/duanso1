<div class="row">
    <div class="col-sm-12">
        <h2>Technical specifications of {{ $model->title }}</h2>
        <?php if($model->getDescription != null && count($model->getDescription) != 0){?>
        <table class="table table-bordered table-hover">
            <tbody>

                <?php foreach ($model->getDescription as $specific):?>
                    <tr>
                        <td>
                            {{ $specific->description }}
                        </td>

                    </tr>
                <?php endforeach;?>

            </tbody>
        </table>
        <?php }else{
            echo "No specifications";
        }?>
    </div>
</div>