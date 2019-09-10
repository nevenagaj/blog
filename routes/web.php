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

Route::get('admin/routes', 'HomeController@admin')->middleware('admin');

//Password Reset routes
/*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/

//Categories
Route::resource('categories', 'CategoryController', ['except'=> ['create']]);
//except pravilo brise rutu za create posto smo u kontroleru obrisali tu metodu
//umesto except moze da se koristi only u tom slucaju se posle only upisuju rute koje zelimo da se pojave


Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');
Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);

Route::get('/contact', 'PagesController@getContact');
Route::get('/about', 'PagesController@getAbout');
Route::get('/', 'PagesController@getIndex');

Route::resource('posts', 'PostController');






//Route::get('/home', 'HomeController@index')->name('home');
