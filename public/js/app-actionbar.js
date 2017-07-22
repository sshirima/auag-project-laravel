var SMSProcessStatus = false;
var index = 0;
var runTimer = null;
$(document).ready(function () {
    checkSMSProcessStatus();
});

function checkSMSProcessStatus() {
    $.ajax({
        method: 'GET',
        url: urlSMSProcessStatus
    }).done(function (response) {
        console.log(response.status);
        setStatusSMSProcess(response.status);
        $('#bt_start_SMS_process').val(response.status);
        processSMS();
    });

}

function setStatusSMSProcess(status) {
    if (status) {
        $('#dv_smsprocess_status').removeClass('progress-bar-warning').
                addClass('progress-bar-primary').
                addClass('active').
                html('SMS process running');
    } else {
        $('#dv_smsprocess_status').removeClass('progress-bar-primary').
                removeClass('active').
                addClass('progress-bar-warning').
                html('SMS process stopped');
    }
    SMSProcessStatus = status;
}

function processSMS() {
    if (runTimer === null) {
        runTimer = setInterval(function () {
            if (SMSProcessStatus) {
                $.ajax({
                    method: 'GET',
                    url: urlSMSProcessRun
                }).done(function (response) {
                    console.log(response.status);
                });
            } else {
                clearInterval(runTimer);
                runTimer = null;
            }
        }, 2000);
    }
}
