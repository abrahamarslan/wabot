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
        Route::get('/results/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignController@getResults', 'as'=>'campaign.results'));

        Route::get('/import/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@getImport', 'as'=>'campaign.contact.import'));
        Route::post('/import/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@postImport', 'as'=>'campaign.contact.postImport'));
        Route::get('/contacts/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@getContacts', 'as'=>'campaign.contact.view'));

        Route::get('/contact/delete/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@delete', 'as'=>'campaign.contact.delete'));
        Route::get('/contact/results/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@getResults', 'as'=>'campaign.contact.results'));
        Route::get('/contact/history/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@getHistory', 'as'=>'campaign.contact.history'));
        Route::get('/contact/history/delete/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@deleteHistory', 'as'=>'campaign.contact.deleteHistory'));

    });


});
