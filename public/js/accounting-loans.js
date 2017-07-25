
var table;
var columns = [{name: 'loan_id', title: 'Ref#'},
    {name: 'loan_account', title: 'Account'},
    {name: 'acc_name', title: 'Acc name'},
    {name: 'loan_principle', title: 'Principle'},
    {name: 'loan_paid', title: 'Paid amount'},
    {name: 'loan_balance', title: 'Outstanding'},
    {name: 'loan_rate', title: 'Rate%'},
    {name: 'loan_duration', title: 'Duration(months)'},
    {name: 'loan_progress', title: 'Progress%'},
    {name: 'loan_interest', title: 'Interest'},
    {name: 'created_at', title: 'Date aquired'},
    {name: '', title: 'Edit/Delete'}];

$(document).ready(function () {

    createTable();
    //Important fields

    //Tootbar field
    table.toolbar[0].position = 'top';
    table.toolbar[0].buttons[0] = {commandName: "insert", caption: 'Process new loan'};
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
    var ig = 1;
    for (var i = 1; i < columns.length; i++) {
        if (i === 11) {
            rows[i-ig] = {
                width: "70px",
                title: columns[11].title,
                buttons: [
                    {commandName: "edit", caption: "Edit"},
                    {commandName: "delete", caption: "Delete"}
                ]
            };
        } else if (i === 1) {
            rows[i-ig] = {field: columns[i].name, title: columns[i].title, width: "70px", editor: dropdownMenu};
        } else {
            rows[i-ig] = {field: columns[i].name, title: columns[i].title, width: "50px"};
        }

    }
    table.columns = rows;
}

function dropdownMenu(cell, item) {
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
