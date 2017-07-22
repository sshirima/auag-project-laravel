@extends('accounting::layouts.master-accounting')
@section('title')
Transactions
@endsection

@section('module-body')
@include('accounting::includes.module-body-transactions-titlebar')

<div id="table-read-write" ></div>

<script>
    var token = '{{ Session::token()}}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<!--<script type="text/javascript" src="{{ URL::asset('js/accounting-transactions.js') }}"></script> -->
@stop
