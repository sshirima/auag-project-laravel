@extends('layouts.master')

@section('title')
SMS sent
@endsection

@section('content-heading')
 @include('includes.content-heading-report')
@endsection

@section('fieldset-legend')
View sent messages
@endsection

@section('fieldset-paragraph')
Here you can  <i>view</i> all messages which have been sent to the members by the system
@endsection

@section('fieldset-tabletitle')
Received messages
@endsection

@section('content-body')
<script>
var token = '{{ Session::token()}}';
var urlRead = '{{ route('readSentSMS')}}';
</script>

<!-- Table-view js file -->
<script type="text/javascript" src="{{ URL::asset('js/app-report-SMSsent.js') }}"></script>
@endsection