<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/home', 'App\Http\Controllers\PlayerController@home')->name('home.info');
Route::get('/top/player/{id}', 'App\Http\Controllers\PlayerController@topPlayer')->name('player.top');
Route::put('/root/edit/{id}', 'App\Http\Controllers\PlayerController@edit')->name('player.edit');
Route::POST('/{member}/add', 'App\Http\Controllers\PlayerController@add')->name('player.regist');
Route::POST('/{member}/clip', 'App\Http\Controllers\PlayerController@clip')->name('player.clip');
Route::get('/{member}/{cate}', 'App\Http\Controllers\PlayerController@cate')->name('player.cate');
Route::get('/{member}/player/{id}', 'App\Http\Controllers\PlayerController@player')->name('player.player');