@extends('layouts.master')

@section('title')
Members
@endsection

@section('content-heading')
@include('includes.content-heading-members')
@endsection

@section('content-body')
@include('includes.content-message-block')
<fieldset>
    <legend>Manage members</legend>
    @if ($message = Session::get('error'))

    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif
    @if ($message = Session::get('success'))
    <p >Imported member information</p>
    <div class="panel-body text-left">
        <div id="table-view"></div>
        <input id="in_member_data" type="hidden" value="{{ Session::get('success') }}">
        <input id="in_url_import" type="hidden" value="{{ route('/members/import')}}">
        <input id="in_token" type="hidden" value="{{ Session::token()}}">
    </div>
    <button id="bt_save_data" class="btn btn-primary" >Save to database</button>
    
    <script type="text/javascript" src="{{ URL::asset('js/app-members-upload.js') }}"></script>

    @else
    <p >Import members information by excel or csv file format</p>
    <form  style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;" action="{{ route('/members/upload') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
        <h4>File to import:</h4>
        <input type="file" id="upload_member_file" name="upload_member_file" />
        {{ csrf_field() }}
        <br/>
        
        <button id="bt_upload_file"class="btn btn-primary" >Import data</button>
        
    </form>
    <br/>
    <p >Export members information into excel or csv file format</p>
    <div style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;"> 
        <h4>Export member information into database:</h4>
        <a href="{{ url('downloadExcel/xls') }}"><button class="btn btn-primary " disabled>Download .xls</button></a>
        <a href="{{ url('downloadExcel/xlsx') }}"><button class="btn btn-primary " disabled>Download .xlsx</button></a>
        <a href="{{ url('downloadExcel/csv') }}"><button class="btn btn-primary " disabled>Download .csv</button></a>
    </div>
    @endif
</fieldset>
<br/>
<div id="dv_save_report" class="alert"></div>

@endsection
