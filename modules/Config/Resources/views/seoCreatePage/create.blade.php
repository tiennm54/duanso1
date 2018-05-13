@extends('backend.master')
@section('content')
<div class="page-header">
    <div class="container-fluid">
        <h1>SEO CREATE PAGE</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ URL::route('admin.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ URL::route('config.seo.index') }}">Seo</a>
            </li>
            <li>
                <a>Create Page</a>
            </li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    @include('validator.flash-message')
    <div class="alert alert-success" style="display: none">
        
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-list"></i> Seo Crate Page Management</h3>
        </div>
        <div class="panel-body">
            <div class="well">
                <div class="row">
                    <form action="" method="post">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Name</label>
                                <input type="text" name="name" placeholder="Name" class="form-control" required>
                                {!! $errors->first('name','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">Router</label>
                                <input type="text" name="code" placeholder="Router" class="form-control" required>
                                {!! $errors->first('code','<span class="control-label color-red" style="color: red">*:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <div class="form-group">
                                <label class="control-label">Create</label>
                                <div>
                                    <button type="submit" class="btn btn-primary pull-right">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td class="text-left">No</td>
                            <td class="text-left">Name</td>
                            <td class="text-left">Router</td>
                            <td class="text-left">Create at</td>
                            <td class="text-right">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($model) == 0): ?> 
                            <tr>
                                <td colspan="8">Không có bản ghi nào</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($model as $key => $item): ?>
                            <tr>
                                <td class="text-left">{{ $key + 1 }}</td>
                                <td class="text-left">
                                    <input value="{{ $item->name }}" class="form-control" id="seo_create_name<?php echo $item->id; ?>">
                                </td>
                                <td class="text-left">
                                    <input value="{{ $item->code }}" class="form-control" id="seo_create_code<?php echo $item->id; ?>">
                                </td>
                                <td class="text-left">{{ $item->created_at }} </td>
                                <td class="text-right">
                                    <b onclick="editSeoPage({{ $item->id }})" data-toggle="tooltip" title="" class="btn btn-primary"
                                       data-original-title="Save">
                                        <i class="fa fa-save"></i>
                                    </b>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function editSeoPage(id){
        var name = $("#seo_create_name"+ id).val();
        var code = $("#seo_create_code" + id).val();
        if (name != "" && code != ""){
            if (confirm("Are you sure you want to save this item?")) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo URL::route('config.seopage.postEdit') ?>",
                    data: {"id": id, "name": name, "code": code},
                    success: function (data) {
                        if (data == 1){
                            $(".alert").show();
                            $(".alert").removeClass("alert-warning");
                            $(".alert").addClass("alert-success");
                            $(".alert").html("Success! Edit SEO page: "+ name +" thành công")
                        } else{
                            $(".alert").show();
                            $(".alert").removeClass("alert-success");
                            $(".alert").addClass("alert-warning")
                            $(".alert").html("Warning! Edit SEO page: " + name + " thất bại !!!");
                        }
                    },
                    error: function (ex) {
                        alert("Không thể Edit do trùng Name hoặc Code!");
                    }
                });
            }
        } else{
            alert("Xin vui lòng điền đầy đủ thông tin bao gồm cả name và code!");
        }
    }
</script>

@stop