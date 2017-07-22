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

/**
 * Routes to modules
 */
Route::get('/', [
    'as' => 'accounting',
    function () {
        return redirect('accounting');
    }]);

Route::get('/old', [
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

Route::get('/dashboard/identifymodem', [
    'uses' => 'DashboardController@postModemIdentify',
    'as' => 'identifymodem']);

Route::get('/device-settings', [
    'uses' => 'DashboardController@getDashboardSettings',
    'as' => '/device-settings']);

Route::post('/startServer', [
    'uses' => 'DashboardController@startServer',
    'as' => 'startServer']);

Route::get('/SMSProcess/status', [
    'uses' => 'SMSProcessorController@processStatus',
    'as' => 'SMSProcessStatus']);

Route::get('/SMSProcess/start', [
    'uses' => 'SMSProcessorController@processStart',
    'as' => 'SMSProcessStart']);

Route::get('/SMSProcess/stop', [
    'uses' => 'SMSProcessorController@processStop',
    'as' => 'SMSProcessStop']);

Route::get('/SMSProcess/run', [
    'uses' => 'SMSProcessorController@processRun',
    'as' => 'SMSProcessRun']);

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
Route::get('/report-SMSinbox', [
    'as' => 'report-SMSinbox',
    function () {
        return view('report-SMSinbox');
    }]);

Route::get('/report-SMSsent', [
    'as' => 'report-SMSsent',
    function () {
        return view('report-SMSsent');
    }]);
Route::get('/report-SMSoutbox', [
    'as' => 'report-SMSoutbox',
    function () {
        return view('report-SMSoutbox');
    }]);

Route::get('/SMS/inbox/read', [
    'uses' => 'InboxController@getAllMessages',
    'as' => 'readInboxSMS']);

Route::get('/SMS/sent/read', [
    'uses' => 'SentItemController@getAllMessages',
    'as' => 'readSentSMS']);

Route::get('/SMS/outbox/read', [
    'uses' => 'OutboxController@getAllMessages',
    'as' => 'readOutboxSMS']);


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

Route::post('/command/add', [
    'uses' => 'CommandController@postAddCommand',
    'as' => '/command/add']);

Route::post('/command/update', [
    'uses' => 'CommandController@postUpdateCommand',
    'as' => '/command/update']);

Route::post('/command/getAll', [
    'uses' => 'CommandController@postGetAllCommands',
    'as' => '/command/getAll']);

Route::post('/command/remove', [
    'uses' => 'CommandController@postDeleteCommand',
    'as' => '/command/remove']);
