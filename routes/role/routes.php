<?php
use Illuminate\Support\Facades\Route;
/*
 * Dashboard
 */
Route::group(array('prefix' => 'role'), function () {
    Route::get('/create', array('uses'=>'App\Http\Controllers\role\RoleController@index', 'as'=>'role.index'));
});
