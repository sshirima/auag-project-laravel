@extends('accounting::layouts.master-accounting')
@section('title')
Accounts
@endsection

@section('module-body')
@include('accounting::includes.module-body-titlebar')
<br>
<div  class="theme-light">
    <div id="filterbox">
        Search:
        <input type="text" />
        <a><img src="" /></a>
    </div>
    <br>
    <div id="rw_table" ></div>
</div>

<script>
    var token = '{{ Session::token()}}';
    var urlTableRead = '{{ route('getAllAccounts')}}';
    var urlTableAdd = '{{ route('addAccount')}}';
    var urlTableUpdate = '{{ route('updateAccount')}}';
    var urlTableDelete = '{{ route('deleteAccount')}}';
    var members = '{{ $members }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-accounts.js') }}"></script>
@stop
