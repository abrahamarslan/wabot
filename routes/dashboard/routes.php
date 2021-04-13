<?php
use Illuminate\Support\Facades\Route;
/*
 * Dashboard
 */
Route::group(array('prefix' => 'dashboard', 'middleware' => 'App\Http\Middleware\authentication\Authentication'), function () {
    Route::get('/', array('uses'=>'App\Http\Controllers\dashboard\DashboardController@index', 'as'=>'dashboard.index'));


    //Campaigns
    Route::group(array('prefix' => 'campaign'), function () {
        Route::get('/', array('uses'=>'App\Http\Controllers\campaign\CampaignController@index', 'as'=>'campaign.index'));
        Route::get('/create', array('uses'=>'App\Http\Controllers\campaign\CampaignController@create', 'as'=>'campaign.create'));
        Route::post('/create', array('uses'=>'App\Http\Controllers\campaign\CampaignController@store', 'as'=>'campaign.store'));
        Route::get('/edit/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignController@update', 'as'=>'campaign.update'));
        Route::post('/edit/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignController@postUpdate', 'as'=>'campaign.postUpdate'));
        Route::get('/delete/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignController@delete', 'as'=>'campaign.delete'));
    });


});
