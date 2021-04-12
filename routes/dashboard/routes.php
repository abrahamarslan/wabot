<?php
use Illuminate\Support\Facades\Route;
/*
 * Dashboard
 */
Route::group(array('prefix' => 'dashboard'), function () {
    Route::get('/', array('as' => 'dashboard.index', 'uses' => 'Dashboard/DashboardController@index'));

});
