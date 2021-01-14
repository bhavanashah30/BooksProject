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

use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('books', 'BookController@index')->name('books');

Route::get('add', 'BookController@create')->name('add');

Route::post('saveBook', 'BookController@store')->name('saveBook');

Route::get('getBooks', 'BookController@getBooks')->name('getBooks');

Route::post('updateBook', 'BookController@update')->name('updateBook');

Route::delete('deleteBook/{id}', 'BookController@destroy')->name('deleteBook');




