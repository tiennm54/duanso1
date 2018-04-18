<?php

Route::group(['prefix' => 'config', 'namespace' => 'Modules\Config\Http\Controllers'], function()
{
    Route::group(['prefix' => 'seo'], function() {
        Route::get('index', ['as' => 'config.seo.index', 'uses' => 'SeoController@index']);
        Route::get('delete/{id}', ['as' => 'config.seo.getDelete', 'uses' => 'SeoController@getDelete']);
        Route::get('create', ['as' => 'config.seo.getCreate', 'uses' => 'SeoController@getCreate']);
        Route::post('create', ['as' => 'config.seo.postCreate', 'uses' => 'SeoController@postCreate']);
        Route::get('edit/{id}', ['as' => 'config.seo.getEdit', 'uses' => 'SeoController@getEdit']);
        Route::post('edit/{id}', ['as' => 'config.seo.postEdit', 'uses' => 'SeoController@postEdit']);
    });
    
    Route::group(['prefix' => 'seo-create-page'], function() {
        Route::get('create', ['as' => 'config.seopage.getCreate', 'uses' => 'SeoCreatePageManagerController@getCreate']);
        Route::post('create', ['as' => 'config.seopage.postCreate', 'uses' => 'SeoCreatePageManagerController@postCreate']);
        Route::post('edit', ['as' => 'config.seopage.postEdit', 'uses' => 'SeoCreatePageManagerController@postEdit']);
        
    });
    
    Route::group(['prefix' => 'image-manager'], function() {
        Route::get('create', ['as' => 'config.image.getCreate', 'uses' => 'ImageManagerController@getCreate']);
        Route::post('create', ['as' => 'config.image.postCreate', 'uses' => 'ImageManagerController@postCreate']);
        Route::get('delete/{id}', ['as' => 'config.image.delete', 'uses' => 'ImageManagerController@delete']);
    });
    
    Route::group(['prefix' => 'bonus-config'], function() {
        Route::get('create', ['as' => 'config.bonusConfig.getCreate', 'uses' => 'BonusConfigController@getCreate']);
        Route::post('create', ['as' => 'config.bonusConfig.postCreate', 'uses' => 'BonusConfigController@postCreate']);
        
    });
});