<div  class="col-md-9" >
    <div class="form-group" >
        <div class="progress-bar progress-bar-striped progress-bar-warning" id="dv_smsprocess_status"
             role="progressbar" aria-valuenow="10" aria-valuemin="10" 
             aria-valuemax="10" style="width: 100%">
        </div>
    </div>
</div>

<div  class="col-md-3" >
    <div class="form-group">
        <div class="col-sm-6">
            <span class="small-nav" data-toggle="tooltip" data-placement="right" title="username"> 
                <span class="fa fa-user"></span> 
            </span>
            <span class="full-nav"> Username </span>
        </div>
        <div class="col-sm-6">
            <a href="#">
                <span class="small-nav" data-toggle="tooltip" data-placement="right" title="username"> 
                    <span class="fa fa-sign-out"></span> 
                </span>
                <span class="full-nav"> Sign out </span>
            </a>
        </div>
    </div>
    <script>
        var urlSMSProcessStatus = '{{ route('SMSProcessStatus')}}';
        var urlSMSProcessRun = '{{ route('SMSProcessRun')}}';
        var token = '{{ Session::token()}}';
    </script>
    <script type="text/javascript" src="{{ URL::asset('js/app-actionbar.js') }}"></script>
</div>
