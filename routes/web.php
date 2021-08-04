<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', 'HomeController@index');
Route::get('/privacy', 'HomeController@privacy');
Route::get('/app_links', 'HomeController@app_links');
Route::get('user/verify', 'HomeController@verify');
Route::get('payment/verify', 'HomeController@payment_verify');

