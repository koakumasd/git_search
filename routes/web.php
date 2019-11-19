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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/search_repo', 'RepositoryController@searchRepo')->name('search_repo');
Route::post('/add_to_favorite', 'RepositoryController@addToFavorite');
Route::post('/remove_from_favorite', 'RepositoryController@removeFromFavorite');
Route::get('/user_favorites', 'RepositoryController@userFavorites')->name('user_favorites');
