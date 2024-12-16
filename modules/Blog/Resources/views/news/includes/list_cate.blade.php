<aside id="column-right" class="col-sm-3 hidden-xs">
    <div class="list-group">
        <?php foreach ($model_cate as $cate): ?>
            <a href="{{ $cate->getUrl() }}" class="list-group-item"><?php echo $cate->name; ?> </a>
        <?php endforeach; ?>
    </div>
</aside>