<?php
use Illuminate\Support\Facades\Route;
/*
 * Dashboard
 */
Route::group(array('prefix' => 'authentication'), function () {
    //Login
    Route::get('/login', array('uses'=>'App\Http\Controllers\authentication\AuthenticationController@index', 'as'=>'authentication.login.index'));
    Route::post('/login', array('uses'=>'App\Http\Controllers\authentication\AuthenticationController@create', 'as'=>'authentication.login.create'));

    //Register
    Route::get('/register', array('uses'=>'App\Http\Controllers\authentication\RegistrationController@index', 'as'=>'authentication.registration.index'));
    Route::post('/register', array('uses'=>'App\Http\Controllers\authentication\RegistrationController@create', 'as'=>'authentication.registration.create'));

    //Recovery
    Route::get('/forgot', array('uses'=>'App\Http\Controllers\authentication\RecoveryController@index', 'as'=>'authentication.recovery.index'));
    Route::post('/forgot', array('uses'=>'App\Http\Controllers\authentication\RecoveryController@create', 'as'=>'authentication.recovery.create'));

    //Reset
    Route::get('/reset/{id}/{code}', array('uses'=>'App\Http\Controllers\authentication\ResetController@index', 'as'=>'authentication.reset.index'));
    Route::post('/reset/{id}/{code}', array('uses'=>'App\Http\Controllers\authentication\ResetController@create', 'as'=>'authentication.reset.create'));

    //Activation
    Route::get('/create/{user}', array('uses'=>'App\Http\Controllers\authentication\ActivationController@getCreateActivation', 'as'=>'authentication.activation.index'));
    Route::get('/{user}/{code}', array('uses'=>'App\Http\Controllers\authentication\ActivationController@getActivateUser', 'as'=>'authentication.activation.create'));

});
