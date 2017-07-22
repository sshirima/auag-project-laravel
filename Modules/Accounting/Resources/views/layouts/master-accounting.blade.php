@extends('layouts.master-global')

@section('module-heading')
<li role="presentation" class="{{ Request::is('accounting') ? 'active' : ''|| Request::is('accounting/members') ? 'active' : '' }}"><a href="{{route('members')}}">Members</a></li>
<li role="presentation" class="{{ Request::is('accounting/accounts*') ? 'active' : '' }}"><a href="{{route('accounts')}}">Accounts</a></li>
<li role="presentation" class="{{ Request::is('accounting/transactions*') ? 'active' : '' }}"><a href="{{route('transactions')}}">Transactions</a></li>
@endsection