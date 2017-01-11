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

Route::get('/', 'MessageController@dashboard')->name('dashboard');
Route::get('inbox', 'MessageController@inbox')->name('inbox');

Route::get('inbox/archive', 'MessageController@viewArchive')->name('message.viewArchive');
Route::group(['prefix' => 'messages'], function () {
    Route::post('/', 'MessageController@store');
    Route::get('{message}/answer', 'MessageController@answerForm')->name('message.answer');
    Route::put('{message}/answer', 'MessageController@answer');
    Route::put('{message}/archive', 'MessageController@archive')->name('message.archive');
    Route::put('{message}/unarchive', 'MessageController@unarchive')->name('message.unarchive');
    Route::delete('{message}', 'MessageController@delete')->name('message.delete');
});

Route::get('invite', 'UserController@listInvites')->name('invite');

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@index');
    Route::put('{user}/follow', 'UserController@follow')->name('user.follow');
    Route::delete('{user}/follow', 'UserController@unfollow');
});

Route::get('settings', 'UserController@settings')->name('settings');
Route::put('settings', 'UserController@saveSettings');

Route::get('{user}', 'UserController@profile')->name('profile');
Route::get('{user}/following', 'UserController@following')->name('user.following');
Route::get('{username}/message/{message}', 'MessageController@permalink')->name('message.permalink');
