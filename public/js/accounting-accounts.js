
var table;
var columnNames = new Array('acc_id', 'acc_name', 'acc_shares', 'acc_fines', 'acc_loan', 'acc_currency', 'acc_member');
var columnTitles = new Array('Account ID', 'Account name', 'Current shares', 'Pending fines', 'Pending loan', 'Currency', 'Member name', 'Edit/Delete');

$(document).ready(function () {

    createTable();
    //Important fields
    tableSchemaField();
    tableColumns();


    //Tootbar field
    table.toolbar[0].position = 'top';
    table.toolbar[0].buttons[0] = {commandName: "insert", caption: 'Add account'};

    $("#rw_table").shieldGrid(table);

    searchfield();
});



function tableSchemaField() {
    var fields = {};
    for (var i = 0; i < columnNames.length; i++) {
        if (i === 0) {
            fields[columnNames[i]] = {path: columnNames[i], type: String};
        } else {
            fields[columnNames[i]] = {path: columnNames[i], type: String};
        }

    }
    table.dataSource.schema.fields = fields;
}

function tableColumns() {
    table.columns = [
        {field: columnNames[6], title: columnTitles[6], width: "50px", editor: dropdownMenu},
        {field: columnNames[1], title: columnTitles[1], width: "50px"},
        {field: columnNames[2], title: columnTitles[2], width: "50px"},
        {field: columnNames[3], title: columnTitles[3], width: "50px"},
        {field: columnNames[4], title: columnTitles[4], width: "50px"},
        {field: columnNames[5], title: columnTitles[5], width: "50px"},
        {
            width: "80px",
            title: columnTitles[7],
            buttons: [
                {commandName: "edit", caption: "Edit"},
                {commandName: "delete", caption: "Delete"}
            ]
        }
    ];
}

function dropdownMenu(cell, item) {
    $('<div id="dropdown"/>')
            .appendTo(cell)
            .shieldDropDown({
                dataSource: {
                    data: JSON.parse(members.replace(/&quot;/g, '"')),
                    filter: {
                        and: [
                            {path: "id", filter: "contains", value: ""}
                        ]
                    }
                },
                textTemplate: function (item) {
                    return item.firstname+' '+item.lastname;
                },
                valueTemplate: "{id}"
            }).
            swidget().
            focus();
}

function searchfield() {
    var dataSource = $("#rw_table").swidget().dataSource,
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

