@extends('layouts.master')

@section('title')
Dashboard
@endsection

@section('content-heading')
@include('includes.content-heading-dashboard')
@endsection

@section('content-body')
<div class="row" >
    <div class="col-md-6">
        <fieldset style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">

            <legend style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">Modems</legend>
            <p >Currently connected to the system:</p>
            @if (is_array($phones))
            @foreach($phones as $phone)
            @foreach($phone as $p)
            <div style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;" class="alert alert-success">
                <ul ><b>Device IMEI: </b>{{$p->IMEI}}</ul>
                <ul ><b>Last time checked: </b>{{$p->UpdatedInDB}}</ul>
            </div>
            @endforeach
            @endforeach
            @else
            No an array
            {{$phones}}
            @endif
            <div hidden style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;" class="alert" id="dv_phone_status">

            </div>
            <button id="btn_identify" class="btn btn-primary" value="stopped">
                Identify modem
            </button>

        </fieldset>
        <div class="form-group" style="padding-top: 10px">
                <span class="small-nav" data-toggle="tooltip" data-placement="right" >
                    <button class="btn btn-primary" id="bt_start_SMS_process" value="false">
                        <span class="small-nav" data-toggle="tooltip" data-placement="right" title="start_SMS_processor"> 
                            <span class="fa fa-play"></span> 
                        </span>
                        <span class="full-nav"> </span>
                    </button> 
                </span>    
        </div>
    </div> 
    <div class="col-md-6" >
        <fieldset style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">

            <legend style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;">SMS service</legend>
            <p >SMS service status information:</p>
            @if ($smsd['state'] == 'running')
            <div id="dv_smsd_status" style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;" class="alert alert-success">
                <ul ><b>State: </b>Running</ul>
                <ul ><b>Process ID: </b>{{$smsd['pid']}}</ul>
            </div>
            <button id="btn_smsd_start" class="btn btn-primary" value="running">Stop service</button>
            @elseif($smsd['state'] == 'stopped')
            <div id="dv_smsd_status" style="border: 1px solid #a1a1a1;margin-top: 15px;padding: 10px;" class="alert alert-danger">
                <ul ><b>Service state: </b>Stopped</ul>
                <ul >Please start SMS service on below button</ul>
            </div>
            <button id="btn_smsd_start" class="btn btn-primary" value="stopped">Start service</button>
            @endif

        </fieldset>
        <input id="in_url_startsmsd" type="hidden" value="{{ route('/dashboard/smsd/start')}}">
        <input id="in_url_stopsmsd" type="hidden" value="{{ route('/dashboard/smsd/stop')}}">
        <input id="_token" name="_token" type="hidden" value="{{ Session::token()}}">
    </div>
</div>
<script>
    var urlIdentifyModem = '{{ route('identifymodem')}}';
    var urlSMSProcessStatus = '{{ route('SMSProcessStatus')}}';
            var urlStartSmsd = '{{ route('/dashboard/smsd/start')}}';
            var urlStopSmsd = '{{ route('/dashboard/smsd/stop')}}';
            var urlSMSProcessStart = '{{ route('SMSProcessStart')}}';
            var urlSMSProcessStop = '{{ route('SMSProcessStop')}}';
    var token = '{{ Session::token()}}';
</script>
<script type="text/javascript" src="{{ URL::asset('js/app-dashboard-monitoring.js') }}"></script>
@endsection
