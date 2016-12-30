<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'MessageController@inbox');

Route::post('/messages', 'MessageController@store');
Route::get('/messages/{message_id}/answer', 'MessageController@answerForm')->name('message.answer');
Route::put('/messages/{message_id}/answer', 'MessageController@answer');

Route::get('/{username}', 'UserController@profile');
