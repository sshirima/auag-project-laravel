@extends('accounting::layouts.master-accounting')
@section('title')
Loans
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
    var urlTableRead = '{{ route('getAllLoans')}}';
    var urlTableAdd = '{{ route('addLoan')}}';
    var urlTableUpdate = '{{ route('updateLoan')}}';
    var urlTableDelete = '{{ route('deleteLoan')}}';
    var accounts = '{{ $accounts }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-loans.js') }}"></script>
@stop

