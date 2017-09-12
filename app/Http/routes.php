<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'email'], function()
{
    Route::get('view-email',['as'=>'email.viewEmail','uses'=>'SendEmailController@viewEmail']);
    Route::get('send-email',['as'=>'email.sendMail','uses'=>'SendEmailController@sendMail']);
});
