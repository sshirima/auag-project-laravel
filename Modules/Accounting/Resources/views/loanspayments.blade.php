@extends('accounting::layouts.master-accounting')
@section('title')
Shares transactions
@endsection

@section('module-body')
@include('accounting::includes.module-body-transactions-titlebar')
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
    var urlTableRead = '{{ route('getAllLoanPayments')}}';
    var urlTableAdd = '{{ route('addLoanPayment')}}';
    var urlTableUpdate = '{{ route('updateLoanPayment')}}';
    var urlTableDelete = '{{ route('deleteLoanPayment')}}';
    var loan_account = '{{ $loan_account }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-loanpayments.js') }}"></script>
@stop

