
var table;
var columnNames = new Array('id', 'firstname', 'lastname', 'phonenumber');
var columnTitles = new Array('Member id', 'Firstname', 'Lastname', 'Phonenumber', 'Edit/Delete');

$(document).ready(function () {
    var gr = JSON.parse(group.replace(/&quot;/g, '"'));
    $('#change_rate').on('click', function () {
        $('#sp_value').html('<input type="text" id="in_rate" placeholder="' + gr.groupln_rate + '"/>');
        $('#change_rate').html('Save');
        $.ajax({
            method: 'POST',
            url: url_group_update,
            data: {_token: token,
                group_id: gr.group_id,
                group_name: gr.group_name,
                groupsh_price: gr.groupsh_price,
                groupsh_max: gr.groupsh_max,
                groupsh_duration: gr.groupsh_duration,
                groupln_rate: ('#in_rate').val()
            }
        }).done(function (response) {
            console.log(response);
        });
    });
    createTable();
    //Important fields
    tableSchemaField();
    tableColumns();


    //Tootbar field
    table.toolbar[0].position = 'top';
    table.toolbar[0].buttons[0] = {commandName: "insert", caption: 'Add member'};


    $("#table-read-write").shieldGrid(table);

    searchfield();
});

function tableSchemaField() {
    var fields = {};
    for (var i = 0; i < columnNames.length; i++) {
        if (i === 0) {
            fields[columnNames[i]] = {path: columnNames[i], type: Number};
        } else {
            fields[columnNames[i]] = {path: columnNames[i], type: String};
        }

    }
    table.dataSource.schema.fields = fields;
}

function tableColumns() {
    table.columns = [
        {field: columnNames[0], title: columnTitles[0], width: "20px"},
        {field: columnNames[1], title: columnTitles[1], width: "50px"},
        {field: columnNames[2], title: columnTitles[2], width: "50px"},
        {field: columnNames[3], title: columnTitles[3], width: "80px"},
        {
            width: "80px",
            title: columnTitles[4],
            buttons: [
                {commandName: "edit", caption: "Edit"},
                {commandName: "delete", caption: "Delete"}
            ]
        }
    ];
}

function searchfield() {
    var dataSource = $("#table-read-write").swidget().dataSource,
            input = $("#filterbox input"),
            timeout,
            value;
    input.on("keydown", function () {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            value = input.val();
            if (value) {
                dataSource.filter = {
                    or: [
                        {path: columnNames[0], filter: "contains", value: value},
                        {path: columnNames[1], filter: "contains", value: value},
                        {path: columnNames[2], filter: "contains", value: value},
                        {path: columnNames[3], filter: "contains", value: value}
                    ]
                };
            } else {
                dataSource.filter = null;
            }
            dataSource.read();
        }, 300);
    });
}


