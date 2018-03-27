<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
	Route::get('/', 'AdminController@index');

    //Route::get('/taotieuchi', 'AdminController@taoTieuChi');

    //ARTICLES
    Route::group(['prefix' => 'product'], function() {

        Route::get('index', ['as' => 'articles.index', 'uses' => 'BackendArticlesController@index']);
        Route::get('create', ['as' => 'articles.getCreate', 'uses' => 'BackendArticlesController@getCreate']);
        Route::post('create', ['as' => 'articles.postCreate', 'uses' => 'BackendArticlesController@postCreate']);
        Route::get('view/{id}/{url?}', ['as' => 'articles.view', 'uses' => 'BackendArticlesController@view']);
        Route::get('edit/{id}/{url?}', ['as' => 'articles.getEdit', 'uses' => 'BackendArticlesController@getEdit']);
        Route::post('edit/{id}/{url?}', ['as' => 'articles.postEdit', 'uses' => 'BackendArticlesController@postEdit']);

    });
    //ARTICLES CHILDREN
    Route::group(['prefix' => 'sub-product'], function() {
        Route::get('create/{articles_id}', ['as' => 'articlesChildren.getCreate', 'uses' => 'BackendArticlesChildrenController@getCreate']);
        Route::post('create/{articles_id}', ['as' => 'articlesChildren.postCreate', 'uses' => 'BackendArticlesChildrenController@postCreate']);
        Route::get('view/{id}/{url?}', ['as' => 'articlesChildren.view', 'uses' => 'BackendArticlesChildrenController@view']);
        Route::get('edit/{id}/{url?}', ['as' => 'articlesChildren.getEdit', 'uses' => 'BackendArticlesChildrenController@getEdit']);
        Route::post('edit/{id}/{url?}', ['as' => 'articlesChildren.postEdit', 'uses' => 'BackendArticlesChildrenController@postEdit']);

        Route::get('autoComplete',['as' => 'articlesChildren.autoComplete', 'uses' => 'BackendArticlesChildrenController@autoComplete']);
        Route::post('addKeyToProduct/{id?}',['as' => 'articlesChildren.addKeyToProduct', 'uses' => 'BackendArticlesChildrenController@addKeyToProduct']);

        Route::get('delete/{id}', ['as' => 'articlesChildren.delete', 'uses' => 'BackendArticlesChildrenController@delete']);

    });
    //CATEGORY
    Route::group(['prefix' => 'category'], function() {
        Route::get('index', ['as' => 'category.index', 'uses' => 'BackendCategoryController@index']);
        Route::get('create', ['as' => 'category.getCreate', 'uses' => 'BackendCategoryController@getCreate']);
        Route::post('create', ['as' => 'category.postCreate', 'uses' => 'BackendCategoryController@postCreate']);
        Route::get('edit/{id}', ['as' => 'category.getEdit', 'uses' => 'BackendCategoryController@getEdit']);
        Route::post('edit/{id}', ['as' => 'category.postEdit', 'uses' => 'BackendCategoryController@postEdit']);
        Route::get('delete/{id}', ['as' => 'category.delete', 'uses' => 'BackendCategoryController@delete']);
    });

    //CATEGORY FAQ
    Route::group(['prefix' => 'category-faq'], function() {
        Route::get('index', ['as' => 'admin.categoryFaq.index', 'uses' => 'BackendCategoryFaqController@index']);
        Route::get('create', ['as' => 'admin.categoryFaq.getCreate', 'uses' => 'BackendCategoryFaqController@getCreate']);
        Route::post('create', ['as' => 'admin.categoryFaq.postCreate', 'uses' => 'BackendCategoryFaqController@postCreate']);
        Route::get('edit/{id}/{url?}', ['as' => 'admin.categoryFaq.getEdit', 'uses' => 'BackendCategoryFaqController@getEdit']);
        Route::post('edit/{id}/{url?}', ['as' => 'admin.categoryFaq.postEdit', 'uses' => 'BackendCategoryFaqController@postEdit']);
        Route::get('delete/{id}', ['as' => 'admin.categoryFaq.delete', 'uses' => 'BackendCategoryFaqController@delete']);
    });


    // FAQ
    Route::group(['prefix' => 'faq'], function() {
        Route::get('index/{category?}', ['as' => 'admin.faq.index', 'uses' => 'BackendFaqController@index']);
        Route::get('create', ['as' => 'admin.faq.getCreate', 'uses' => 'BackendFaqController@getCreate']);
        Route::post('create', ['as' => 'admin.faq.postCreate', 'uses' => 'BackendFaqController@postCreate']);
        Route::get('edit/{id}/{url?}', ['as' => 'admin.faq.getEdit', 'uses' => 'BackendFaqController@getEdit']);
        Route::post('edit/{id}/{url?}', ['as' => 'admin.faq.postEdit', 'uses' => 'BackendFaqController@postEdit']);
        Route::get('delete/{id}', ['as' => 'admin.faq.delete', 'uses' => 'BackendFaqController@delete']);
    });


    //PAYMENT TYPE
    Route::group(['prefix' => 'payment-type'], function() {
        Route::get('index', ['as' => 'paymentType.index', 'uses' => 'BackendPaymentTypeController@index']);
        Route::get('create', ['as' => 'paymentType.getCreate', 'uses' => 'BackendPaymentTypeController@getCreate']);
        Route::post('create', ['as' => 'paymentType.postCreate', 'uses' => 'BackendPaymentTypeController@postCreate']);
        Route::get('edit/{id}', ['as' => 'paymentType.getEdit', 'uses' => 'BackendPaymentTypeController@getEdit']);
        Route::post('edit/{id}', ['as' => 'paymentType.postEdit', 'uses' => 'BackendPaymentTypeController@postEdit']);
        Route::get('delete/{id}', ['as' => 'paymentType.delete', 'uses' => 'BackendPaymentTypeController@delete']);
    });
    //TERMS CONDITIONS
    Route::group(['prefix' => 'terms-conditions'], function() {
        Route::get('view', ['as' => 'termsConditions.getView', 'uses' => 'BackendTermsConditionsController@getView']);
        Route::post('view', ['as' => 'termsConditions.postView', 'uses' => 'BackendTermsConditionsController@postView']);
    });


    Route::group(['prefix' => 'import'], function() {
        Route::get('import-key/{id?}', ['as' => 'import.getImport', 'uses' => 'ImportKeyController@getImport']);
        Route::post('import-key', ['as' => 'import.postImport', 'uses' => 'ImportKeyController@postImport']);
    });

    //USER ORDER
    Route::group(['prefix' => 'user-orders'], function() {
        Route::get('list', ['as' => 'adminUserOrders.listOrders', 'uses' => 'AdminUserOrdersController@listOrders']);
        Route::get('view/{id}', ['as' => 'adminUserOrders.viewOrders', 'uses' => 'AdminUserOrdersController@viewOrders']);
        Route::post('sendKey/{id}', ['as' => 'adminUserOrders.sendKey', 'uses' => 'AdminUserOrdersController@sendKey']);
        Route::get('autoCompleteEmail', ['as' => 'adminUserOrders.autoCompleteEmail', 'uses' => 'AdminUserOrdersController@autoCompleteEmail']);
        Route::post('saveStatusPayment/{id}', ['as' => 'adminUserOrders.saveStatusPayment', 'uses' => 'AdminUserOrdersController@saveStatusPayment']);
        Route::post('saveHistory/{id}', ['as' => 'adminUserOrders.saveHistory', 'uses' => 'AdminUserOrdersController@saveHistory']);

        Route::get('add-premium-key/{product_id}/{order_detail_id}', ['as' => 'adminUserOrders.getAddPremiumKey', 'uses' => 'AdminUserOrdersController@getAddPremiumKey']);
        Route::post('add-premium-key/{product_id}/{order_detail_id}', ['as' => 'adminUserOrders.postAddPremiumKey', 'uses' => 'AdminUserOrdersController@postAddPremiumKey']);
        Route::post('delete-premium-key/{id}', ['as' => 'adminUserOrders.deletePremiumKey', 'uses' => 'AdminUserOrdersController@deletePremiumKey']);
        Route::post('save-premium-key/{id}', ['as' => 'adminUserOrders.savePremiumKey', 'uses' => 'AdminUserOrdersController@savePremiumKey']);
    });


    Route::group(['prefix' => 'information'], function() {

        Route::get('create', ['as' => 'admin.information.getCreate', 'uses' => 'InformationController@getCreate']);
        Route::post('create', ['as' => 'admin.information.postCreate', 'uses' => 'InformationController@postCreate']);
        Route::get('index', ['as' => 'admin.information.index', 'uses' => 'InformationController@index']);

        Route::get('edit/{id?}', ['as' => 'admin.information.getEdit', 'uses' => 'InformationController@getEdit']);
        Route::post('edit/{id?}', ['as' => 'admin.information.postEdit', 'uses' => 'InformationController@postEdit']);

    });


    Route::group(['prefix' => 'user-management'], function() {
        Route::get('index', ['as' => 'admin.userManagement.index', 'uses' => 'UserManagementController@index']);
        Route::get('view/{id}', ['as' => 'admin.userManagement.view', 'uses' => 'UserManagementController@view']);
        Route::post('updateMoney/{id}', ['as' => 'admin.userManagement.updateMoney', 'uses' => 'UserManagementController@updateMoney']);
    });

    Route::group(['prefix' => 'news'], function() {
        Route::get('index', ['as' => 'admin.news.index', 'uses' => 'BackendNewsController@index']);
        Route::get('create', ['as' => 'admin.news.getCreate', 'uses' => 'BackendNewsController@getCreate']);
        Route::post('create', ['as' => 'admin.news.postCreate', 'uses' => 'BackendNewsController@postCreate']);

        Route::get('edit/{id?}', ['as' => 'admin.news.getEdit', 'uses' => 'BackendNewsController@getEdit']);
        Route::post('edit/{id?}', ['as' => 'admin.news.postEdit', 'uses' => 'BackendNewsController@postEdit']);
    });

});