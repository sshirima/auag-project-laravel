$(document).ready(function () {
    $('#btn_smsd_start').on('click', function () {

        if ($('#btn_smsd_start').val() === 'running') {
            $('#dv_smsd_status').html('Stopping <b>sms service</b>').removeClass('alert-success').addClass('alert-danger');
            $('#btn_smsd_start').html('Stopping...');
            $.ajax({
                method: 'GET',
                url: urlStopSmsd,
                data: {_token: token}

            }).done(function (msg) {
                console.log(JSON.stringify(msg));
                $('#dv_smsd_status').html('<ul ><b>Service state: </b>Stopped</ul><ul >Please start SMS service on below button</ul>');
                $('#btn_smsd_start').html('Start service').val('stopped');
            });
        } else if($('#btn_smsd_start').val() === 'stopped') {
            $('#dv_smsd_status').html('Starting <b>sms service</b>');
            $('#btn_smsd_start').html('Staring...');
            $.ajax({
                method: 'GET',
                url: urlStartSmsd,
                data: {_token: token}

            }).done(function (msg) {
                console.log(JSON.stringify(msg));
                $('#dv_smsd_status').removeClass('alert-danger').addClass('alert-success');
                $('#btn_smsd_start').html('Stop service').val('running');
                $('#dv_smsd_status').html('<ul ><b>State: </b>Running</ul><ul ><b>Process ID: </b>' + msg.pid + '</ul>');
            });
        }

    });
    
    $('#btn_identify').on('click', function(){
        $('#btn_identify').
                html('<span class="small-nav" data-toggle="tooltip" data-placement="right" title="Identify">'+ 
                    '<span class="fa fa-spinner fa-pulse fa-1x fa-fw"></span>'+ 
                '</span>'+
                '<span class="full-nav"> Identifying... </span>');
        
        $.ajax({
            method:'GET',
            url: urlIdentifyModem
        }).done(function(msg){
            console.log(JSON.stringify(msg));
            $('#btn_identify').html('Identify modem');
            if (msg.response.status === 'OK'){
                 $('#dv_phone_status').
                         addClass('alert-success').
                         removeClass('alert-danger').
                         html('<ul >Device port: '+msg.response.output.Device+'</ul>'+
                         '<ul >Manufacturer: '+msg.response.output.Manufacturer+'</ul>'+
                         '<ul >Model: '+msg.response.output.Model+'</ul>'+
                         '<ul >Firmware: '+msg.response.output.Firmware+'</ul>'+
                         '<ul >IMEI: '+msg.response.output.IMEI+'</ul>'+
                         '<ul >IMSI: '+msg.response.output.IMSI+'</ul>').
                         show();
            } else {
                $('#dv_phone_status').
                        addClass('alert-danger').
                        removeClass('alert-success').
                        html(msg.response.output).
                        show();
            }
        });
    });
});


