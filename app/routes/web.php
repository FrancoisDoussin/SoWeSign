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

Route::get('/', 'RDSController@index')->name('index');
Route::post('/create-admin', 'RDSController@createAdmin')->name('create-admin');
Route::post('/context', 'RDSController@context')->name('context');
Route::post('/signatories', 'RDSController@signatories')->name('signatories');
Route::post('/invitation', 'RDSController@invitation')->name('invitation');
Route::post('/confirmation', 'RDSController@confirmation')->name('confirmation');
