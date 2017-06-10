@extends('layouts.master')

@section('title')
Commands
@endsection

@section('content-heading')
 @include('includes.content-heading-commands')
@endsection

@section('fieldset-legend')
Manage SMS commands
@endsection

@section('fieldset-paragraph')
Here you can  <i>view</i>, <i>add</i>,  <i>edit</i> or  <i>delete</i> sms commands which members use to 
get their information to the system
@endsection

@section('fieldset-tabletitle')
SMS commands
@endsection

@section('content-body')
<script>
var token = '{{ Session::token()}}';
var urlRead = '{{ route('/command/getAll')}}';
var urlCreate = '{{ route('/command/add')}}';
var urlUpdate = '{{ route('/command/update')}}';
var urlRemove = '{{ route('/command/remove')}}';
</script>

<!-- Table-view js file -->
<script type="text/javascript" src="{{ URL::asset('js/app-commands-view.js') }}"></script>
@endsection
