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

Route::get('inbox/archive', 'MessageController@archivedMessages');
Route::group(['prefix' => 'messages'], function () {
    Route::post('/', 'MessageController@store');
    Route::get('{message}/answer', 'MessageController@answerForm')->name('message.answer');
    Route::put('{message}/archive', 'MessageController@archive')->name('message.archive');
    Route::put('{message}/unarchive', 'MessageController@unarchive')->name('message.unarchive');
    Route::delete('{message}', 'MessageController@delete')->name('message.delete');
    Route::put('{message}/answer', 'MessageController@answer');
});

Route::get('/invite', 'UserController@listInvites')->name('invite');

Route::get('/settings', 'UserController@settings')->name('settings');
Route::put('/settings', 'UserController@saveSettings');

Route::get('/{user}', 'UserController@profile')->name('profile');
