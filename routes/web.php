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
});

Route::get('/invoice', function () {
    return view('invoice');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Member controller routes
Route::resource('/members', 'MembersController');

/*
|keep at last of all routes
|404 error when refresh on vue routes 
*/
Route::get('{path}', 'HomeController@index')->where('path','([A-z\d-/_.]+)?');