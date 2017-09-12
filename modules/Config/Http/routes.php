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
});