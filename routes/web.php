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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get', 'ArkitController@getImage');
Route::any('targetList', 'ArkitController@targetList');
Route::any('createTarget', 'ArkitController@createTarget');


Route::any('objectsPosition', 'ArkitController@objPosition');
Route::any('objectClear', 'ArkitController@clear');