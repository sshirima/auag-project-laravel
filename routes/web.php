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
Route::get('/', function () {
    return view('dashboard-monitoring');
});

Route::get('/dashboard', function () {
    return view('dashboard-monitoring');
});

Route::get('/device-settings', function () {
    return view('dashboard-device-settings');
});

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


