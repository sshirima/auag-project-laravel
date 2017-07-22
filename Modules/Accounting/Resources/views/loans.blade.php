@extends('accounting::layouts.master-accounting')
@section('title')
Shares transactions
@endsection

@section('module-body')
@include('accounting::includes.module-body-titlebar')
<p >
    Below table display information about loans taken by the group members.<br>
    Each loan is associated with a specific member account, for more information click 
<a href="#">here</a>

</p>
<div id="table-read-write" ></div>

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

