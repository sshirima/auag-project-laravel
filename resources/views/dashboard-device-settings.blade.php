@extends('layouts.master')

@section('title')
Device settings
@endsection

@section('content-heading')
@include('includes.content-heading-dashboard')
@endsection

@section('content-body')

<fieldset style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">
    <legend style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">
        Gammu settings
    </legend>
    <form class="form-horizontal" >
        <div class="form-group">
            <label for="device" class="col-sm-2 control-label">Device:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->device}}" class="form-control" name="device" id="device" placeholder="Port">
            </div>
            <div for="gammu_device" class="col-sm-4">
                <p> Port which modem is connected</p>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="form-group">
            <label for="connection" class="col-sm-2 control-label">Connection Type:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->connection}}" class="form-control" id="connection" name="connection" placeholder="Connection">
            </div>
            <div for="gammu_connection" class="col-sm-4">
                <p> They type of connection used by your modem device</p>
            </div>
        </div>
        <div class="form-group">
            <label for="logfile" class="col-sm-2 control-label">Logfile directory:</label>
            <div class="col-sm-4">
                <input type="text" value="{{$configs->logfile}}" class="form-control" name="logfile" id="logfile" placeholder="Directory">
            </div>
        </div>
        <input type="hidden" value="{{Session::token()}}" name="_token">
    </form>
    <div class="form-group">
        <div >
            <button class="btn btn-primary "  id="bt_gammu_saveconfig">Save configuration</button>
        </div>
    </div>
    
    <div class="form-group">
        <div >
            <div hidden id="dv_gammu_save_response" class="alert"></div>
        </div>
    </div>
</fieldset>


<fieldset style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">
    <legend style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">
        SQL settings
    </legend>
    <form class="form-horizontal" >
        <div class="form-group">
            <label for="service" class="col-sm-2 control-label">Database service:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->service}}"value="" class="form-control" id="service" name="service" placeholder="Service">
            </div>
            <label for="driver" class="col-sm-2 control-label">Database driver:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->driver}}"class="form-control" id="driver" name="driver" placeholder="Driver">
            </div>
            <label for="host" class="col-sm-2 control-label">Database host:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->host}}"class="form-control" id="host" name="host" placeholder="Host">
            </div>
        </div>
        <div class="form-group">
            <label for="sql" class="col-sm-2 control-label">SQL used:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->sql}}"class="form-control" id="sql" name="sql" placeholder="SQL">
            </div>
            <label for="username" class="col-sm-2 control-label">Username:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->username}}"class="form-control" id="user" name="user" placeholder="Username">
            </div>
            <label for="password" class="col-sm-2 control-label">Password:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->password}}"class="form-control" id="password" name="password" placeholder="Password">
            </div>

        </div>
        <div class="form-group">
            <label for="database" class="col-sm-2 control-label">Database:</label>
            <div class="col-sm-2">
                <input type="text" value="{{$configs->database}}" class="form-control" id="database" name="database" placeholder="Database">
            </div>

        </div>
        </br>
        <input type="hidden" value="{{Session::token()}}" name="_token">
    </form>
    <div class="form-group">
        <div >
            <button class="btn btn-primary "  id="bt_smsd_saveconfig">Save configuration</button>
        </div>
    </div>
    
    <div class="form-group">
        <div >
            <div hidden id="dv_smsd_save_response" class="alert"></div>
        </div>
    </div>
</fieldset>
<script >
    var token = '{{ Session::token()}}';
var urlGammuSave = '{{ route('/dashboard/gammu/saveconfig')}}';
var urlSmsdSave = '{{ route('/dashboard/smsd/saveconfig')}}';</script>

<script type="text/javascript" src="{{ URL::asset('js/app-dashboard-settings.js') }}"></script>
@endsection
