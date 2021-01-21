<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('getBooks', 'BookController@getBooks');
Route::get('booksInDescendingOrder', 'BookController@getBooksInDescendingOrder');
Route::post('saveBook', 'BookController@store');
Route::post('updateBook', 'BookController@update');
Route::delete('deleteBook/{id}', 'BookController@destroy');
