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


Route::get('/', 'PagesController@posts')->name('home');
Route::get('/profile/{name}', 'PagesController@userPage')->name('user');

Route::get('/posts/{post}', 'PagesController@post')->name('post');
Route::post('/posts/delete', 'PagesController@deletePost');
Route::post('/comment', 'commentsController@store');
Route::post('/comment/delete', 'commentsController@delete');
Route::post('/like', 'commentsController@like');
Route::get('/category/{name}', 'PagesController@category')->name('category');
Route::post('notifications', 'PagesController@getNotifications')->name('notifications');

//**********************************************
Route::group(['middleware' => 'roles', 'roles' => ['admin']], function () {
    Route::get('/admin', 'PagesController@admin')->name('adminRoute');
    Route::post('/add_role', 'PagesController@addRole')->name('add_role');
});

// OR ******************************************
//Route::get('/admin', [
//    'uses' => 'PagesController@admin',
//    'as' => 'adminRoute',
//    'middleware' => 'roles',
//    'roles' => ['admin']
//]);
//
//Route::post('/add_role', [
//    'uses' => 'PagesController@addRole',
//    'as' => 'add_role', // Like *****  ->name('add_role')
//    'middleware' => 'roles',
//    'roles' => ['admin']
//]);
//***********************************************
Route::group(['middleware' => 'roles', 'roles' => ['editor', 'admin']], function () {
    Route::get('/editor', 'PagesController@editor')->name('editor');
    Route::post('/posts/store', 'PagesController@store');

});
//Route::get('/editor', [
//    'uses' => 'PagesController@editor',
//    'as' => 'editor',
//    'middleware' => 'roles',
//    'roles' => ['admin', 'editor']
//]);

Route::get('/register', 'RegistrationController@create')->name('register');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', 'SessionController@create')->name('login');
Route::post('/login', 'SessionController@store');
Route::get('/logout', 'SessionController@destroy')->name('logout');

Route::get('/search', 'SearchController@Search')->name('Search');

