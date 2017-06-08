$(document).ready(function () {
    var token = $('#in_token').val();
    var urlStartSmsd = $('#in_url_startsmsd').val();
    var urlStopSmsd = $('#in_url_stopsmsd').val();
    $('#btn_smsd_start').on('click', function () {

        if ($('#btn_smsd_start').val() === 'running') {
            $('#dv_smsd_status').html('Stopping <b>sms service</b>').removeClass('alert-success').addClass('alert-danger');

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
            $('#btn_smsd_start').html('Staring');
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
});


