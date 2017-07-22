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
    var urlTableRead = '{{ route('getAllShareBids')}}';
    var urlTableAdd = '{{ route('addShareBid')}}';
    var urlTableUpdate = '{{ route('updateShareBid')}}';
    var urlTableDelete = '{{ route('deleteShareBid')}}';
    var account_share = '{{ $account_share }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-sharebids.js') }}"></script> 
@stop

