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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'front'], function (){
    Route::group(['namespace'=>'home', 'as'=>'home.'], function (){
        Route::get('/', 'indexController@index')->name('index');
    });
//    prefix adres satirinda gozukecek olan url i belirtir. www.tugrandemirel.com/musteriler gibi
    Route::group(['namespace'=>'musteriler', 'as'=>'musteriler.', 'prefix'=>'musteriler'], function (){

        Route::get('/', 'indexController@index')->name('index');
        Route::get('/olustur', 'indexController@create')->name('create');
        Route::post('/olustur', 'indexController@store')->name('store');
        Route::get('/duzenle/{id}', 'indexController@edit')->name('edit');
        Route::post('/duzenle/{id}', 'indexController@update')->name('update');
        Route::get('/sil/{id}', 'indexController@delete')->name('delete');
    });

});
