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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['namespace' => 'Views\Frontend'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('about', 'HomeController@about');
    Route::get('terms', 'HomeController@terms');
    Route::get('contact', 'HomeController@contact');
    Route::get('privacy', 'HomeController@privacy');
    Route::get('become-chef', 'HomeController@chef');
    Route::post('contact', 'HomeController@postContact');
    Route::post('newsletter', 'HomeController@postEmail');
});
