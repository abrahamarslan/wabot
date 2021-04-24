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
        Route::get('/contact/results/{campaign}/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@getResults', 'as'=>'campaign.contact.results'));
        Route::get('/contact/history/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@getHistory', 'as'=>'campaign.contact.history'));
        Route::get('/contact/history/delete/{id}', array('uses'=>'App\Http\Controllers\campaign\CampaignContactController@deleteHistory', 'as'=>'campaign.contact.deleteHistory'));

    });

    //Sequence
    Route::group(array('prefix' => 'sequence'), function () {
        Route::get('/view/{campaign}', array('uses'=>'App\Http\Controllers\sequence\SequenceController@index', 'as'=>'sequence.index'));
        Route::get('/create', array('uses'=>'App\Http\Controllers\sequence\SequenceController@create', 'as'=>'sequence.create'));
        Route::post('/create', array('uses'=>'App\Http\Controllers\sequence\SequenceController@store', 'as'=>'sequence.store'));
        Route::get('/edit/{id}', array('uses'=>'App\Http\Controllers\sequence\SequenceController@update', 'as'=>'sequence.update'));
        Route::post('/edit/{id}', array('uses'=>'App\Http\Controllers\sequence\SequenceController@postUpdate', 'as'=>'sequence.postUpdate'));
        Route::get('/delete/{id}', array('uses'=>'App\Http\Controllers\sequence\SequenceController@delete', 'as'=>'sequence.delete'));
        Route::get('/results/{id}', array('uses'=>'App\Http\Controllers\sequence\SequenceController@getResults', 'as'=>'sequence.results'));

        Route::get('/sort/{campaign}', array('uses'=>'App\Http\Controllers\sequence\SequenceController@getSort', 'as'=>'sequence.getSort'));
        Route::post('/sort', array('uses'=>'App\Http\Controllers\sequence\SequenceController@postSort', 'as'=>'sequence.postSort'));

        Route::get('/conditionals/{campaign}', array('uses'=>'App\Http\Controllers\sequence\ConditionalController@getConditionals', 'as'=>'sequence.getConditionals'));
        Route::post('/conditionals', array('uses'=>'App\Http\Controllers\sequence\ConditionalController@postConditionals', 'as'=>'sequence.postConditionals'));

        Route::post('/get-options', array('uses'=>'App\Http\Controllers\sequence\ConditionalController@postConditionalOptions', 'as'=>'sequence.postConditionalOptions'));
        Route::post('/add-conditional', array('uses'=>'App\Http\Controllers\sequence\ConditionalController@postAddConditional', 'as'=>'sequence.postAddConditional'));
    });

    //Export
    Route::group(array('prefix' => 'export'), function () {
        Route::get('/', array('uses'=>'App\Http\Controllers\export\ExportController@index', 'as'=>'export.index'));
        Route::get('/create', array('uses'=>'App\Http\Controllers\export\ExportController@create', 'as'=>'export.create'));
        Route::post('/create', array('uses'=>'App\Http\Controllers\export\ExportController@store', 'as'=>'export.store'));
    });

    //Setting
    Route::group(array('prefix' => 'setting'), function () {
        Route::get('/', array('uses'=>'App\Http\Controllers\setting\SettingController@index', 'as'=>'setting.index'));
        Route::get('/create', array('uses'=>'App\Http\Controllers\setting\SettingController@create', 'as'=>'setting.create'));
        Route::post('/create', array('uses'=>'App\Http\Controllers\setting\SettingController@store', 'as'=>'setting.store'));
        Route::get('/edit/{id}', array('uses'=>'App\Http\Controllers\setting\SettingController@update', 'as'=>'setting.update'));
        Route::post('/edit/{id}', array('uses'=>'App\Http\Controllers\setting\SettingController@postUpdate', 'as'=>'setting.postUpdate'));
        Route::get('/delete/{id}', array('uses'=>'App\Http\Controllers\setting\SettingController@delete', 'as'=>'setting.delete'));
    });
});
