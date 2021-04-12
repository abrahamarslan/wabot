<?php
use Illuminate\Support\Facades\Route;
/*
 * Dashboard
 */
Route::group(array('prefix' => 'dashboard'), function () {
    Route::get('/', array('uses'=>'App\Http\Controllers\dashboard\DashboardController@index', 'as'=>'dashboard.index'));

});
