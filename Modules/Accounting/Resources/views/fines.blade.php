@extends('accounting::layouts.master-accounting')
@section('title')
Member fines
@endsection

@section('module-body')
@include('accounting::includes.module-body-titlebar')
<p >
    Below table display information about each member's fines<br>
    Member fines are linked with member account and more information about member can be found 
<a href="#">here</a>

</p>
<div id="table-read-write" ></div>

<script>
    var token = '{{ Session::token()}}';
    var urlTableRead = '{{ route('getAllFines')}}';
    var urlTableAdd = '{{ route('addFine')}}';
    var urlTableUpdate = '{{ route('updateFine')}}';
    var urlTableDelete = '{{ route('deleteFine')}}';
    var accounts = '{{ $accounts }}';
</script>
<!-- Read and Write table scr        ipt -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-fines.js') }}"></script>
@stop

