
var table;
var columns = [{name: 'finepay_id', title: 'Ref#'},
    {name: 'acc_name', title: 'Account name'},
    {name: 'finepay_fineid', title: 'Paid fine ref#'},
    {name: 'finedesc_desc', title: 'Description'},
    {name: 'finepay_amount', title: 'Amount'},
    {name: 'acc_currency', title: 'Currency'},
    {name: 'created_at', title: 'Date paid'},
    {name: '', title: 'Delete'}];


$(document).ready(function () {
    createTable();
    //Important fields
    tableSchemaField();
    tableColumns();

    //Tootbar fields
    table.toolbar[0].position = 'top';
    table.toolbar[0].buttons[0] = {commandName: "insert", caption: 'New fine payment'};
    //Disable modifying capability
    table.dataSource.remote.modify.update = null;
    //Disable click on the table
    $("#rw_table").shieldGrid(table);

    searchfield();
});

function tableSchemaField() {
    var fields = {};
    for (var i = 0; i < columns.length; i++) {
        fields[columns[i].name] = {path: columns[i].name, type: String};
    }
    table.dataSource.schema.fields = fields;
}

function tableColumns() {
    var rows = Array(columns.length);
    var ig = 1;
    for (var i = 1; i < columns.length; i++) {
        if (i === 7) {
            rows[i - ig] = {
                width: "50px",
                title: columns[7].title,
                buttons: [
                    {commandName: "edit", caption: ""},
                    {commandName: "delete", caption: "Delete"}
                ]
            };
        } else if (i === 2) {
            rows[i - ig] = {field: columns[i].name, title: columns[i].title, width: "70px", editor: account_list};
        }  else {
            rows[i - ig] = {field: columns[i].name, title: columns[i].title, width: "50px"};
        }

    }
    table.columns = rows;
}

function account_list(cell, item) {
    $('<div id="dropdown"/>')
            .appendTo(cell)
            .shieldDropDown({
                dataSource: {
                    data: JSON.parse(fines.replace(/&quot;/g, '"')),
                    filter: {
                        and: [
                            {path: "acc_id", filter: "contains", value: ""}
                        ]
                    }
                },
                textTemplate: function (item) {
                    return item.fine_id+':'+item.acc_name;
                },
                valueTemplate: "{fine_id}"
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
                        {path: columns[2].name, filter: "contains", value: value}
                    ]
                };
            } else {
                dataSource.filter = null;
            }
            dataSource.read();
        }, 300);
    });
}

