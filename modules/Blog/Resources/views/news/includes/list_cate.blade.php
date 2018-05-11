<aside id="column-right" class="col-sm-3 hidden-xs">
    <div class="list-group">
        <?php foreach ($model_cate as $cate): ?>
            <a href="{{ URL::route('frontend.news.cate', ['id'=> $cate->id, "url" => $cate->path_url . ".html"]) }}" class="list-group-item"><?php echo $cate->name; ?> </a>
        <?php endforeach; ?>
    </div>
    <div class="fb-page" data-href="https://www.facebook.com/buypremiumkey/" data-tabs="timeline" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/buypremiumkey/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/buypremiumkey/">Buy Premium Key</a></blockquote></div>
</aside>