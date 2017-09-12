<div class="row">
    <div class="col-md-8">
        <h3>{{ $model->title }}</h3>
    </div>
</div>

<div class="row">

    <div class="col-md-8">
        <div class="form-group">
            <label for="exampleInputEmail1">SEO Title (<span class="count-seo-title"></span>)/65-70</label>
            <input type="text" class="form-control border-input seo-title" onkeyup="countCharactersSeoTitle()" placeholder="SEO Title..." name="txt_seo_title" value="{{ ($model->seo_title) ?  $model->seo_title : "" }}">
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">SEO Description (<span class="count-seo-des"></span>)/120-160</label>
            <textarea class="form-control border-input seo-des" onkeyup="countCharactersSeoDescription()" name="txt_seo_description" rows="5">{!! ($model->seo_description) ? $model->seo_description : "" !!}</textarea>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail1">SEO Keyword (<span class="count-seo-keyword"></span>)</label>
            <textarea class="form-control border-input seo-keyword" onkeyup="countCharactersSeoKeyword()" name="txt_seo_keyword" rows="5">{!! ($model->seo_keyword) ? $model->seo_keyword : "" !!}</textarea>
        </div>
    </div>
</div>
