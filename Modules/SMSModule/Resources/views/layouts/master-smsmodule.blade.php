@extends('layouts.master-global')

@section('module-heading')
<li role="presentation" class="{{ Request::is('smsmodule') ? 'active' : ''|| Request::is('smsmodule/dashboard') ? 'active' : '' }}"><a href="{{route('dashboard')}}">Dashboard</a></li>
<li role="presentation" class="{{ Request::is('smsmodule/smscommands') ? 'active' : '' }}"><a href="{{route('smscommands')}}">SMS commands</a></li>
<li role="presentation" class="{{ Request::is('smsmodule/smsreports') ? 'active' : '' }}"><a href="{{route('smsreports')}}">SMS reports</a></li>

@endsection