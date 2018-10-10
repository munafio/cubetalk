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

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{name}', "usersController@profile")->name('profile');
Route::get('/{name}/settings', "usersController@settings")->middleware('auth');
Route::get('/{name}/sent', "usersController@sentPage")->middleware('auth')->name('sent');
Route::post('searchUsers', "usersController@search");
Route::post('general_update', "usersController@s_general")->name("general_update");
Route::post('password_update', "usersController@s_password")->name("password_update");
Route::post('delete_account', "usersController@delete_account")->name("delete_account");
Route::post('/send_feedback', 'postsController@send_feedback')->name('send_feedback');
Route::post('/postPrivacy', 'postsController@postPrivacy')->name('postPrivacy');
Route::post('/comment', 'commentsController@comment')->name('comment');
Route::post('/showComments', 'commentsController@showComments')->name('showComments');
Route::post('/deleteComment', 'commentsController@deleteComment')->name('deleteComment');
Route::post('/deletePost', 'postsController@deletePost')->name('deletePost');
Route::get('/lang/{lang}', 'langController@index');