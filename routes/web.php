<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
Route::get('/', [
    'uses' => 'DashboardController@getDashboardMonitoring',
    'as' => 'dashboard']);

Route::get('/dashboard', [
    'uses' => 'DashboardController@getDashboardMonitoring',
    'as' => 'dashboard']);

Route::get('/dashboard/smsd/start', [
    'uses' => 'DashboardController@smsdStart',
    'as' => '/dashboard/smsd/start']);

Route::get('/dashboard/smsd/stop', [
    'uses' => 'DashboardController@smsdStop',
    'as' => '/dashboard/smsd/stop']);

Route::post('/dashboard/smsd/saveconfig', [
    'uses' => 'DashboardController@smsdSaveConfig',
    'as' => '/dashboard/smsd/saveconfig']);

Route::post('/dashboard/gammu/saveconfig', [
    'uses' => 'DashboardController@gammuSaveConfig',
    'as' => '/dashboard/gammu/saveconfig']);

Route::get('/device-settings', [
    'uses' => 'DashboardController@getDashboardSettings',
    'as' => '/device-settings']);

Route::get('/members', function () {
    return view('members-view');
});

Route::get('/members-import', [
    'as' => 'members-import',
    function () {
        return view('members-import');
    }]);

Route::get('/commands', function () {
    return view('commands-view');
});

Route::get('/command-actions', function () {
    return view('command-actions');
});

Route::get('/report', function () {
    return view('report');
});

Route::post('/member/add', [
    'uses' => 'MemberController@postAddMember',
    'as' => '/member/add'
]);

Route::post('/members/all', [
    'uses' => 'MemberController@postSelectMembersAll',
    'as' => '/members/all'
]);

Route::post('/member/update', [
    'uses' => 'MemberController@postUpdateMember',
    'as' => '/member/update'
]);

Route::post('/member/load', [
    'uses' => 'MemberController@postLoadMember',
    'as' => '/member/load'
]);

Route::post('/member/remove', [
    'uses' => 'MemberController@postRemoveMember',
    'as' => '/member/remove'
]);

Route::post('/members/upload', [
    'uses' => 'MemberController@postUploadMembers',
    'as' => '/members/upload']);

Route::post('/members/import', [
    'uses' => 'MemberController@postImportMembers',
    'as' => '/members/import']);


