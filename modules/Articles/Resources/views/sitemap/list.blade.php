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
    
    <url>
        <loc>{{ URL::route('users.feedback.getFeedBack') }}</loc>
    </url>
    
    <url>
        <loc>{{ URL::route('users.guestOrder.guestGetKey') }}</loc>
    </url>
    
    <url>
        <loc>{{ URL::route('frontend.news.index') }}</loc>
    </url>
    
    <url>
        <loc>{{ URL::route('users.review.index') }}</loc>
    </url>
    
    <url>
        <loc>{{ URL::route('product.reviews.index') }}</loc>
    </url>
    
    @foreach($model_information as $info)
        <url>
            <loc>{{ URL::route('frontend.information.view',["id"=> $info->id, 'url'=>$info->url_title.".html"]) }}</loc>
        </url>
    @endforeach

    @foreach($model_product as $product)
        <url>
            <loc>{{ $product->getUrlPricing() }}</loc>
        </url>
    @endforeach


    @foreach($model_product_detail as $product_detail)
        <url>
            <loc>{{ $product_detail->getUrl() }}</loc>
        </url>
    @endforeach
    
    
    @foreach($model_cate as $cate)
        <url>
            <loc>{{ $cate->getUrl() }}</loc>
        </url>
    @endforeach
    
    @foreach($model_news as $news)
        <url>
            <loc>{{ $news->getUrl() }}</loc>
        </url>
    @endforeach
    
    @foreach($model_cate_faq as $cate_faq)
        <url>
            <loc>{{ $cate_faq->getUrl() }}</loc>
        </url>
    @endforeach
    
    @foreach($model_faq as $faq)
        <url>
            <loc>{{ $faq->getUrl() }}</loc>
        </url>
    @endforeach
    
    @foreach($model_product_reviews as $review)
        <url>
            <loc>{{ $review->getUrl() }}</loc>
        </url>
    @endforeach

</urlset>