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

Route::get('download-csv-subscribers', function () {

	$susbscribers = \App\MailSubscribers::all();

	$csvExporter = new \Laracsv\Export();

	return $csvExporter->build($susbscribers, ['id' => 'Id', 'first_name' => 'First Name','last_name' => 'Last Name','email' => 'Email Address','created_at'])->download(time().'-'.'subscribers.csv');

});

Route::get('login/google', 'Auth\LoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/send', 'EmailController@send');
Route::post('/notify', 'EmailController@notify');

Route::get('/compose', function () {
    return view('emails.compose');
});

Route::get('sendNotification', 'HomeController@sendNotification');

/*
|keep at last of all routes
|404 error when refresh on vue routes 
*/
Route::get('{path}', 'HomeController@index')->where('path','([A-z\d-/_.]+)?');