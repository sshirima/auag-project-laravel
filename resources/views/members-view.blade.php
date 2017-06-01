@extends('layouts.master')
@section('title')
Members
@endsection

@section('content-heading')
@include('includes.content-heading-members')
@endsection

@section('content-body')
<fieldset>
    <legend>Manage members</legend>
    <p >Here you can  <i>view</i>, <i>add</i>,  <i>edit</i> or  <i>delete</i> member information in the database</p>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="text-center">Members</h4>
        </div>
        <div class="panel-body text-left">
            <div id="table-view"></div>
        </div>
         <!--<button id="memberUpdate">Update member</button>--> 
    </div>
</fieldset>

<script>
var token = '{{ Session::token()}}';
var urlRead = '{{ route('/members/all')}}';
var urlCreate = '{{ route('/member/add')}}';
var urlUpdate = '{{ route('/member/update')}}';
var urlRemove = '{{ route('/member/remove')}}';
</script>

<!-- Table-view js file -->
<script type="text/javascript" src="{{ URL::asset('js/app-members-view.js') }}"></script>
@endsection
