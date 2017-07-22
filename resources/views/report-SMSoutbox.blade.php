@extends('layouts.master')

@section('title')
SMS outbox
@endsection

@section('content-heading')
 @include('includes.content-heading-report')
@endsection

@section('fieldset-legend')
View outbox messages
@endsection

@section('fieldset-paragraph')
Here you can  <i>view</i> all the outbox messages ready to be sent to the members
<br>If the message is in the outbox for the long time, probably the SMSService process is not running
@endsection

@section('fieldset-tabletitle')
Outbox messages
@endsection

@section('content-body')
<script>
var token = '{{ Session::token()}}';
var urlRead = '{{ route('readOutboxSMS')}}';
</script>

<!-- Table-view js file -->
<script type="text/javascript" src="{{ URL::asset('js/app-report-SMSoutbox.js') }}"></script>
@endsection