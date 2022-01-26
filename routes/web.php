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
Route::get('{member}/add', 'App\Http\Controllers\PlayerController@addindex')->name('player.add');
Route::get('{member}/{cate?}', 'App\Http\Controllers\PlayerController@index')->name('player.index');
Route::get('{member}/player/{id?}', 'App\Http\Controllers\PlayerController@index')->name('player.share');
/*
Route::get('mayo/player/{cate?}', function () {
    return view('players/mayoPlayer');
});
*/
Route::get('/', function () {
    return view('welcome');
});