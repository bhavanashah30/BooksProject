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

Route::get('bookSuggestions', 'BookController@bookSuggestions')->name('bookSuggestions');

Route::get('getBookSuggestions', 'BookController@getBooksFromPublicAPI')->name('booksSuggested');

Route::get('add', 'BookController@create')->name('add');





