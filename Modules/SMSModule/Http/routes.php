<?php

Route::group(['middleware' => 'web', 'prefix' => 'smsmodule', 'namespace' => 'Modules\SMSModule\Http\Controllers'], function() {
    
    Route::get('/', [
        'as' => 'smsmodule',
        'uses' => 'SMSModuleController@index']);

    Route::get('/dashboard', [
        'as' => 'dashboard',
        function () {
            return view('smsmodule::dashboard');
        }]);
    
 

    Route::get('/smscommands', [
        'as' => 'smscommands',
        function () {
            return view('smsmodule::smscommands');
        }]);
    Route::get('/smsreports', [
        'as' => 'smsreports',
        function () {
            return view('smsmodule::smsreports');
        }]);
});
