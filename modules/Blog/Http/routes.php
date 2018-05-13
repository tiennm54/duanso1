<?php

Route::group(['prefix' => 'news', 'namespace' => 'Modules\Blog\Http\Controllers'], function()
{
    Route::get('all',['as'=>'frontend.news.index','uses'=>'NewsController@index']);
    Route::get('view-{id}/{url?}',['as'=>'frontend.news.view','uses'=>'NewsController@view']);
    Route::get('category-{id}/{url?}',['as'=>'frontend.news.cate','uses'=>'NewsController@newsCate']);
    Route::post('comment/{id}',['as'=>'frontend.news.comment','uses'=>'NewsController@postComment']);
    Route::post('commentReply/{id}',['as'=>'frontend.news.commentReply','uses'=>'NewsController@postCommentReply']);
    Route::post('editComment',['as'=>'frontend.news.editComment','uses'=>'NewsController@editComment']);
});