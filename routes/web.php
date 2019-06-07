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

Route::get('/', 'AttorneyController@index')->name('home');

Route::post('/submit', 'AttorneyController@store')->name('store');

Route::get('/list/{state?}', 'AttorneyController@list')->name('list');
Route::post('/list', 'AttorneyController@list')->name('list');

Route::get('/approve', [ 'middleware' => 'auth', 'uses' => 'AttorneyController@approve' ])->name('approve');

Route::get('/attorney/{id}', [ 'middleware' => 'auth', 'uses' => 'AttorneyController@single' ])->name('single');
Route::get('/attorney/download/{id}', [ 'middleware' => 'auth', 'uses' => 'AttorneyController@download' ])->name('download');
Route::post('/attorney/{id}', [ 'middleware' => 'auth', 'uses' => 'AttorneyController@single_update' ])->name('single_update');
Route::post('/attorney/delete/{id}', [ 'middleware' => 'auth', 'uses' => 'AttorneyController@destroy' ])->name('destroy');

Auth::routes();

Route::match(['get','post'], 'register', function () {
    return view('main');
})->name('register');

Route::get('/home', 'HomeController@index')->name('home');
