<footer id="footer">
    <a href="http://www.opencart.com">Buy Premium Key</a> © 2009-2017 All Rights Reserved.<br>Version 1.0
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            // other options
        });
    </script>

    <script type="text/javascript">
        var path = "{{ URL::route('articlesChildren.autoComplete') }}";
        $('input.typeahead').typeahead({
            source: function (query, process) {
                return $.get(path, {query: query}, function (data) {
                    return process(data);
                });
            },
            updater: function (item) {
                $('#id_product').val(item.id);
                $("#text_product_id").text(item.id);
                return item;
            }
        });

        var pathProduct = "{{ URL::route('articles.autoComplete') }}";
        $('input.typeahead-product').typeahead({
            source: function (query, process) {
                return $.get(pathProduct, {query: query}, function (data) {
                    return process(data);
                });
            },
            updater: function (item) {
                $('#id_product_select').val(item.id);
                return item;
            }
        });


        function countCharactersSeoTitle() {
            var stringSeoTitle = $(".seo-title").val();
            var count = stringSeoTitle.length;
            $(".count-seo-title").text(count)
        }

        function countCharactersSeoDescription() {
            var stringSeoDes = $(".seo-des").val();
            var count = stringSeoDes.length;
            $(".count-seo-des").text(count)
        }

        function countCharactersSeoKeyword() {
            var stringSeoKeyword = $(".seo-keyword").val();
            var count = stringSeoKeyword.length;
            $(".count-seo-keyword").text(count)
        }

        $(document).ready(function () {
            if ($(".seo-title")[0]) {
                countCharactersSeoTitle();
                countCharactersSeoDescription();
                countCharactersSeoKeyword();
            }
        });
    </script>



</footer>
