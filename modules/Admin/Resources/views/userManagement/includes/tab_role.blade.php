<div class="row">
    <form method="post" action="<?php echo URL::route('admin.userManagement.changeRole',['id' => $model->id]);?>">
        <div class="col-md-4">
            <div class="form-group">
                <label >Role</label>
                <select class="form-control" name="role_id">
                    <option value="">Select Role</option>
                    <?php foreach ($model_role as $item): ?>
                        <option value="<?php echo $item->id; ?>" <?php echo (isset($model) && $model->role->id == $item->id) ? "selected" : "" ?>><?php echo $item->title; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group" style="margin-top: 20px">
                <button type="submit" class="btn btn-primary" data-toggle="confirmation">Save</button>
            </div>
        </div>
    </form>
</div>