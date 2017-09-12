<?php

Route::group(['prefix' => 'blog', 'namespace' => 'Modules\Blog\Http\Controllers'], function()
{
	Route::get('/', 'BlogController@index');
});



Route::group(['prefix' => 'admin/news', 'namespace' => 'Modules\Blog\Http\Controllers'], function()
{
    Route::get('create',['as'=>'admin.news.getCreate','uses'=>'NewsController@getCreate']);
});