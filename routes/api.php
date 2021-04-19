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
Route::post('/receive-response', array('uses'=>'App\Http\Controllers\message\ReceiverController', 'as'=>'message.getResponse'));
Route::post('/receive-message', array('uses'=>'App\Http\Controllers\message\MessageController', 'as'=>'message.receiveMessage'));
Route::get('/post-message/{campaign}', array('uses'=>'App\Http\Controllers\message\DispatchController@index', 'as'=>'message.getDispatch'));
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
