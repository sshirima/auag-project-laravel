@extends('layouts.master')
@section('title')
Members
@endsection

@section('content-heading')
@include('includes.content-heading-members')
@endsection

@section('fieldset-legend')
Manage members
@endsection

@section('fieldset-paragraph')
Here you can  <i>view</i>, <i>add</i>,  <i>edit</i> or  <i>delete</i> member information in the database
@endsection

@section('fieldset-tabletitle')
Members
@endsection

@section('content-body')
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
