<?php

//KHÔNG LÀM THÌ KHÔNG THỂ XONG => KHÔNG XONG THÌ KHÔNG CÓ TIỀN
Route::group(['prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('login', ['as' => 'users.getLogin', 'uses' => 'UsersController@getLogin']);
    Route::post('login', ['as' => 'users.postLogin', 'uses' => 'UsersController@postLogin']);
    Route::get('logout', ['as' => 'users.getLogout', 'uses' => 'UsersController@getLogout']);
    Route::get('logout-success', ['as' => 'users.afterLogout', 'uses' => 'UsersController@afterLogout']);

    Route::get('register', ['as' => 'users.getRegister', 'uses' => 'UsersController@getRegister']);
    Route::post('register', ['as' => 'users.postRegister', 'uses' => 'UsersController@postRegister']);
    Route::get('register-success', ['as' => 'users.getRegisterSuccess', 'uses' => 'UsersController@getRegisterSuccess']);

    Route::get('forgotten', ['as' => 'users.getForgotten', 'uses' => 'UsersController@getForgotten']);
    Route::post('forgotten', ['as' => 'users.postForgotten', 'uses' => 'UsersController@postForgotten']);
    Route::get('reset-password/{user_email}/{key_forgotten}', ['as' => 'users.getResetPassword', 'uses' => 'UsersController@getResetPassword']);
    Route::post('reset-password/{user_email}/{key_forgotten}', ['as' => 'users.postResetPassword', 'uses' => 'UsersController@postResetPassword']);

    Route::get('getStateCountry', ['as' => 'users.getStateCountry', 'uses' => 'UsersController@getStateCountry']);
    Route::get('viewEmail', ['as' => 'users.viewEmail', 'uses' => 'UsersController@viewEmail']);
});


Route::group(['prefix' => 'users/profile', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('my-account.html', ['as' => 'users.getMyAccount', 'uses' => 'UsersProfileController@getMyAccount']);
    Route::get('edit', ['as' => 'users.getEditProfile', 'uses' => 'UsersProfileController@getEditProfile']);
    Route::post('edit', ['as' => 'users.postEditProfile', 'uses' => 'UsersProfileController@postEditProfile']);
    Route::get('change-password', ['as' => 'users.getChangePassword', 'uses' => 'UsersProfileController@getChangePassword']);
    Route::post('change-password', ['as' => 'users.postChangePassword', 'uses' => 'UsersProfileController@postChangePassword']);
});


Route::group(['prefix' => 'users/wish-list', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('index.html', ['as' => 'users.getWishList', 'uses' => 'WishListController@getWishList'])->middleware('member');
    Route::post('addWishlist', ['as' => 'users.addWishlist', 'uses' => 'WishListController@addWishlist']);
    Route::post('deleteWishList/{id}', ['as' => 'users.deleteWishList', 'uses' => 'WishListController@deleteWishList'])->middleware('member');
});

Route::group(['prefix' => 'users/shipping-address', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('index.html', ['as' => 'users.shippingAddress.getShippingAddress', 'uses' => 'ShippingAddressController@getShippingAddress']);
    Route::post('add', ['as' => 'users.shippingAddress.addShippingAddress', 'uses' => 'ShippingAddressController@addShippingAddress']);
    Route::post('delete/{id}', ['as' => 'users.shippingAddress.deleteShippingAddress', 'uses' => 'ShippingAddressController@deleteShippingAddress']);
    Route::post('setPrimaryShippingAddress/{id}', ['as' => 'users.shippingAddress.setPrimaryShippingAddress', 'uses' => 'ShippingAddressController@setPrimaryShippingAddress']);
});


Route::group(['prefix' => 'users/order-history', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('index.html', ['as' => 'users.orderHistory', 'uses' => 'OrderHistoryController@listOrder']);
    Route::get('view-{id}/{order_no?}', ['as' => 'users.orderHistoryView', 'uses' => 'OrderHistoryController@view']);
    Route::get('userCancelOrder/{id}', ['as' => 'users.getCancelOrder', 'uses' => 'OrderHistoryController@getCancelOrder']);
    Route::post('userCancelOrder/{id}', ['as' => 'users.postCancelOrder', 'uses' => 'OrderHistoryController@postCancelOrder']);
});

Route::group(['prefix' => 'users/team', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('index.html', ['as' => 'users.team', 'uses' => 'TeamController@listTeam']);
});

Route::group(['prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('contact-us', ['as' => 'users.contact.getContact', 'uses' => 'ContactController@getContact']);
    Route::post('contact-us', ['as' => 'users.contact.postContact', 'uses' => 'ContactController@postContact']);
});


Route::group(['prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('get-premium-key.html', ['as' => 'users.guestOrder.guestGetKey', 'uses' => 'UserGetKeyController@guestGetKey']);
    Route::post('get-premium-key.html', ['as' => 'users.guestOrder.postGuestGetKey', 'uses' => 'UserGetKeyController@postGuestGetKey']);
});

Route::group(['prefix' => 'users', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('feed-back', ['as' => 'users.feedback.getFeedBack', 'uses' => 'FeedBackController@getFeedBack']);
    Route::post('feed-back', ['as' => 'users.feedback.postFeedBack', 'uses' => 'FeedBackController@postFeedBack']);
    Route::get('review.html', ['as' => 'users.review.index', 'uses' => 'ReviewController@index']);
    Route::post('rateWebsite', ['as' => 'users.review.rateWebsite', 'uses' => 'ReviewController@rateWebsite']);
});


Route::group(['prefix' => 'reviews', 'namespace' => 'Modules\Users\Http\Controllers'], function() {
    Route::get('index.html', ['as' => 'product.reviews.index', 'uses' => 'ReviewController@listReviews']);
    Route::get('premium-{id}/{url?}', ['as' => 'product.reviews.reviewsProduct', 'uses' => 'ReviewController@reviewsProduct']);
});