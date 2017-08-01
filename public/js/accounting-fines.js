
var table;
var columns = [{name: 'fine_id', title: 'Ref#'},
    {name: 'fine_account', title: 'Account ID'},
    {name: 'acc_name', title: 'Account name'},
    {name: 'finedesc_amount', title: 'Fined amount'},
    {name: 'finedesc_desc', title: 'Description'},
    {name: 'fine_outstanding', title: 'Remain paid'},
    {name: 'fine_paid', title: 'Paid amount'},
    {name: 'created_at', title: 'Date created'},
    {name: '', title: 'Edit/Delete'}];

$(document).ready(function () {

    createTable();
    //Important fields

    //Tootbar field
    table.toolbar[0].position = 'top';
    table.toolbar[0].buttons[0] = {commandName: "insert", caption: 'Add new fine'};
    tableSchemaField();

    tableColumns();

    //Option fields

    $("#rw_table").shieldGrid(table);

    searchfield();
});

function tableSchemaField() {
    var fields = {};
    for (var i = 0; i < columns.length; i++) {
        if (i === 10){
            fields[columns[i].name] = {path: columns[i].name, type: String};
        } else {
            fields[columns[i].name] = {path: columns[i].name, type: String};
        }
    }
    table.dataSource.schema.fields = fields;
}

function tableColumns() {
    var rows = Array(columns.length);
    var ig = 0;
    for (var i = 0; i < columns.length; i++) {
        if (i === 8) {
            rows[i-ig] = {
                width: "70px",
                title: columns[8].title,
                buttons: [
                    {commandName: "edit", caption: ""},
                    {commandName: "delete", caption: "Delete"}
                ]
            };
        } else if (i === 1) {
            rows[i-ig] = {field: columns[i].name, title: columns[i].title, width: "70px", editor: account_list};
        } else if (i === 4) {
            rows[i-ig] = {field: columns[i].name, title: columns[i].title, width: "70px", editor: description_list};
        } else {
            rows[i-ig] = {field: columns[i].name, title: columns[i].title, width: "50px"};
        }

    }
    table.columns = rows;
}

function account_list(cell, item) {
    $('<div id="dropdown"/>')
            .appendTo(cell)
            .shieldDropDown({
                dataSource: {
                    data: JSON.parse(accounts.replace(/&quot;/g, '"')),
                    filter: {
                        and: [
                            {path: "acc_id", filter: "contains", value: ""}
                        ]
                    }
                },
                textTemplate: function (item) {
                    return item.acc_name;
                },
                valueTemplate: "{acc_id}"
            }).
            swidget().
            focus();
}
function description_list(cell, item) {
    $('<div id="wg_second"/>')
            .appendTo(cell)
            .shieldDropDown({
                dataSource: {
                    data: JSON.parse(descriptions.replace(/&quot;/g, '"')),
                    filter: {
                        and: [
                            {path: "finedesc_id", filter: "contains", value: ""}
                        ]
                    }
                },
                textTemplate: function (item) {
                    return item.finedesc_desc;
                },
                valueTemplate: "{finedesc_id}"
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