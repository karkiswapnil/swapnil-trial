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

Route::get('download-csv', function () {

	$users = \App\User::all();

	$csvExporter = new \Laracsv\Export();

	return $csvExporter->build($users, ['id', 'name', 'email','role','created_at'])->download(time().'-'.'users.csv');

});

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

/*
|keep at last of all routes
|404 error when refresh on vue routes 
*/
Route::get('{path}', 'HomeController@index')->where('path','([A-z\d-/_.]+)?');