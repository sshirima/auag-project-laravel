@extends('layouts.master-global')

@section('module-heading')
<li role="presentation" class="{{ Request::is('admin') ? 'active' : ''|| Request::is('admin/users') ? 'active' : '' }}"><a href="{{route('users')}}">Users</a></li>
<li role="presentation" class="{{ Request::is('admin/settings') ? 'active' : '' }}"><a href="{{route('settings')}}">Settings</a></li>

@endsection