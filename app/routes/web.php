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

Route::get('/error', function() {
    return view('error');
})->name('error');

Route::post('/parse-pdf', 'RDSController@parsePDF')->name('parse-pdf');

Route::get('/admin', 'RDSController@createAdmin')->name('create-admin');
Route::post('/admin', 'RDSController@storeAdmin')->name('store-admin');

Route::get('/context', 'RDSController@createContext')->name('create-context');
Route::post('/context', 'RDSController@storeContext')->name('store-context');

Route::get('/signatories', 'RDSController@createSignatories')->name('create-signatories');
Route::post('/signatories', 'RDSController@storeSignatories')->name('store-signatories');

Route::get('/invitation', 'RDSController@createInvitation')->name('create-invitation');
Route::post('/invitation', 'RDSController@storeInvitation')->name('store-invitation');

Route::get('/confirmation', 'RDSController@confirmation')->name('confirmation');

Route::get('/sign/{hash}', 'SignatoryController@sign')->name('sign');

Route::post('/upload', 'SignatoryController@upload')->name('upload');

Route::get('/sign-success', 'SignatoryController@signSuccess')->name('sign-success');