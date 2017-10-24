<?php echo '<?xml version="1.0" encoding="UTF-8"?>'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ URL::route('frontend.articles.index') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('frontend.articles.getListProduct') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('frontend.checkout.index') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.getMyAccount') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.getLogin') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.getRegister') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.getRegisterSuccess') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.afterLogout') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.getForgotten') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.orderHistory') }}</loc>
    </url>


    <url>
        <loc>{{ URL::route('users.getWishList') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.shippingAddress.getShippingAddress') }}</loc>
    </url>

    <url>
        <loc>{{ URL::route('users.contact.getContact') }}</loc>
    </url>

    @foreach($model_information as $info)
        <url>
            <loc>{{ URL::route('frontend.information.view',["id"=> $info->id, 'url'=>$info->url_title.".html"]) }}</loc>
        </url>
    @endforeach

    @foreach($model_product as $product)
        <url>
            <loc>{{ URL::route('frontend.articles.pricing',["id"=> $product->id, 'url'=>$product->url_title.".html"]) }}</loc>
        </url>
    @endforeach


    @foreach($model_product_detail as $product_detail)
        <url>
            <loc>{{ URL::route('frontend.articles.view',["id"=> $product_detail->id, 'url'=>$product_detail->url_title.".html"]) }}</loc>
        </url>
    @endforeach

</urlset>