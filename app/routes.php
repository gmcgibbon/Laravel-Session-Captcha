<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// all routes
Route::group(['before' => 'lockout'], function()
{
	Route::get('/', 
		[
			'as'   => 'comment.create',
			'uses' => 'CommentController@create'
		]);

	Route::post('/comment/add', 
		[
			'as'   => 'comment.add',
			'uses' => 'CommentController@add'
		]);

	Route::get('/comment/all', 
		[
			'as'   => 'comment.all',
			'uses' => 'CommentController@all'
		]);

	Route::get('/captcha/show', 
		[
			'as'   => 'captcha.show',
			'uses' => 'CaptchaController@show'
		]);

});
