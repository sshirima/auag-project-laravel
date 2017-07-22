@extends('accounting::layouts.master-accounting')
@section('title')
Members
@endsection

@section('module-body')
 
<div  class="theme-light">
    <div id="filterbox">
        Search:
        <input type="text" />
        <a><img src="" /></a>
    </div>
    <br>
    <div id="table-read-write" ></div>
</div>

<script>
    var token = '{{ Session::token()}}';
    var urlTableRead = '{{ route('getAllMembers')}}';
    var urlTableAdd = '{{ route('addMember')}}';
    var urlTableUpdate = '{{ route('updateMember')}}';
    var urlTableDelete = '{{ route('deleteMember')}}';
</script>
<!-- Read and Write table script -->
<script type="text/javascript" src="{{ URL::asset('js/table-read-write.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/accounting-members.js') }}"></script>
@endsection
