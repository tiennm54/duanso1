<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">URL Title: </label>
            <span>{{ $model->url_title }}</span>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="exampleInputEmail1">SEO Title: </label>
            <span>{{ $model->seo_title }}</span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">SEO Description: </label>
            <span>{!!  $model->seo_description !!} </span>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">SEO Keyword: </label>
            <span>{!!  $model->seo_keyword !!} </span>
        </div>
    </div>

</div>