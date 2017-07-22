<?php

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers'], function()
{
    Route::get('/', [
        'as' => 'admin',
        'uses' => 'AdminController@index']);
        
    Route::get('/users', [
        'as' => 'users',
        function () {
            return view('admin::users');
        }]);
    Route::get('/settings', [
        'as' => 'settings',
        function () {
            return view('admin::settings');
        }]);
});
