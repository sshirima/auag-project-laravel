@extends('layouts.master')

@section('title')
SMS inbox
@endsection

@section('content-heading')
 @include('includes.content-heading-report')
@endsection

@section('fieldset-legend')
View received messages
@endsection

@section('fieldset-paragraph')
Here you can  <i>view</i> all messages which have been received by the system
@endsection

@section('fieldset-tabletitle')
Received messages
@endsection

@section('content-body')
<script>
var token = '{{ Session::token()}}';
var urlRead = '{{ route('readInboxSMS')}}';
</script>

<!-- Table-view js file -->
<script type="text/javascript" src="{{ URL::asset('js/app-report-SMSinbox.js') }}"></script>
@endsection
