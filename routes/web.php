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

Route::get('/', 'MessageController@inbox')->name('inbox');

Route::post('/messages', 'MessageController@store');
Route::get('/messages/{message}/answer', 'MessageController@answerForm')->name('message.answer');
Route::put('/messages/{message}/answer', 'MessageController@answer');

Route::get('/invite', 'UserController@listInvites')->name('invite');

Route::get('/settings', 'UserController@settings')->name('settings');
Route::put('/settings', 'UserController@saveSettings');

Route::get('/{user}', 'UserController@profile')->name('profile');
