@extends('accounting::layouts.master-accounting')
@section('title')
Shares transactions
@endsection

@section('module-body')
@include('accounting::includes.module-body-transactions-titlebar')
<br>
<div id="table-read-write" ></div>

<script>
    var token = '{{ Session::token()}}';
    var urlTableRead = '{{ route('getAllFinePayments')}}';
    var urlTableAdd = '{{ route('addFinePayment')}}';
    var urlTableUpdate = '{{ route('updateFinePayment')}}';
    var urlTableDelete = '{{ route('deleteFinePayment')}}';
    var accounts = '{{ $accounts }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-finepayments.js') }}"></script>
@stop
