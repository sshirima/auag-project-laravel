$(document).ready(function () {

    $('#bt_gammu_saveconfig').on('click', function () {
        var device = $('#device').val();
        var connection = $('#connection').val();
        var logfile = $('#logfile').val();
        var configs = {"device": device, "connection": connection, "logfile": logfile};
        
        $('#dv_gammu_save_response').on().
                html('Saving configuration...').
                addClass('alert-warning').
                show();
        $.ajax({
            method: 'POST',
            url: urlGammuSave,
            data: {configs: configs, _token: token}

        }).done(function (msg) {
            console.log(JSON.stringify(msg));
            if (msg.response.status === 'OK') {
                $('#dv_gammu_save_response').on().
                        html('Configurations has been saved <b>successful!</b>').
                        removeClass('alert-warning').
                        addClass('alert-success').
                        show();

            } else if (msg.response.status === 'FAIL') {
                $('#dv_gammu_save_response').on().
                        html('Failed to save <b>configurations!</b>').
                        removeClass('alert-warning').
                        addClass('alert-success').
                        show();
            } else
            {
                $('#dv_gammu_save_response').on().
                        html('Could not update <b>configurations!</b>').
                        addClass('alert-warning').
                        show();
            }
        });

    });
    $('#bt_smsd_saveconfig').on('click', function () {
        var service = $('#service').val();
        var driver = $('#driver').val();
        var host = $('#host').val();
        var sql = $('#sql').val();
        var username = $('#user').val();
        var password = $('#password').val();
        var database = $('#database').val();
        var configs = {"service": service,
            "driver": driver,
            "host": host,
            "sql": sql,
            "user": username,
            "password": password,
            "database": database};
        $('#dv_smsd_save_response').on().
                html('Saving configuration...').
                addClass('alert-warning').
                show();
        $.ajax({
            method: 'POST',
            url: urlSmsdSave,
            data: {configs: configs,_token: token}

        }).done(function (msg) {
            console.log(JSON.stringify(msg));
            if (msg.response.status === 'OK') {
                $('#dv_smsd_save_response').on().
                        html('Smsd configuration saved').
                        removeClass('alert-warning').
                        addClass('alert-success').
                        show();
            } else if (msg.response.status === 'FAIL') {
                $('#dv_smsd_save_response').on().
                        html('Failed to save <b>configurations!</b>').
                        removeClass('alert-warning').
                        addClass('alert-danger').
                        show();
            }
            else {
                $('#dv_smsd_save_response').on().
                        html('Could not update <b>configurations!</b>').
                        removeClass('alert-warning').
                        addClass('alert-danger').
                        show();
            }
        });

    });
});


