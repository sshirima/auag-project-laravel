
var table;


$(document).ready(function () {

    field1 = 'field1';
    field2 = 'field2';
    field3 = 'field3';
    field4 = 'field4';
    field5 = 'field5';

    colName1 = 'trans_id';
    colName2 = 'trans_account';
    colName3 = 'trans_amount';
    colName4 = 'trans_currency';
    colName5 = 'trans_category';

    colTitle2 = 'Account ID';
    colTitle3 = 'Amount';
    colTitle4 = 'Currency';
    colTitle5 = 'Category';
    colTitle6 = 'Edit/Delete';

    //Get members Ids
    
    
    createTable();
    //Important fields
    tableDatasourceRemoteRead();
    tableDatasourceRemoteModify();
    tableSchemaField();
    tableColumns();

    //Optional fields
    tableEditing();
    tableTool();
    tableExportOptions();

    $("#table-read-write").shieldGrid(table);
});

function tableDatasourceRemoteRead() {
    table.dataSource.remote.read = {
        url: urlTableRead,
        type: "post",
        dataType: "json"
    };
}

function tableDatasourceRemoteModify() {
    table.dataSource.remote.modify = {
        create: {
            url: urlTableAdd,
            type: "post",
            dataType: "json",
            data: function (edited) {
                return JSON.parse('{"' +
                        colName2 + '": "' + edited[0].data[field2] + '","' +
                        colName3 + '": "' + edited[0].data[field3] + '","' +
                        colName4 + '": "' + edited[0].data[field4] + '","' +
                        colName5 + '": "' + edited[0].data[field5] + '"}');
            }
        },
        update: {
            url: urlTableUpdate,
            type: "post",
            dataType: "json",
            data: function (edited) {
                return JSON.parse('{"' +
                        colName1 + '": "' + edited[0].data[field1] + '","' +
                        colName2 + '": "' + edited[0].data[field2] + '","' +
                        colName3 + '": "' + edited[0].data[field3] + '","' +
                        colName4 + '": "' + edited[0].data[field4] + '","' +
                        colName5 + '": "' + edited[0].data[field5] + '"}');
            }
        },
        remove: {
            url: urlTableDelete,
            type: "post",
            data: function (removed) {
                return JSON.parse('{"'+colName1+'": "'+removed[0].data[field1]+'"}');
            }
        }
    };
}

function tableSchemaField() {
    table.dataSource.schema.fields = {
        field1: {path: colName1, type: Number},
        field2: {path: colName2, type: Number},
        field3: {path: colName3, type: String},
        field4: {path: colName4, type: String},
        field5: {path: colName5, type: String}
    };
}

function tableColumns() {
    table.columns = [
        {field: field2, title: colTitle2, width: "50px"},
        {field: field3, title: colTitle3, width: "50px"},
        {field: field4, title: colTitle4, width: "50px"},
        {field: field5, title: colTitle5, width: "50px"},
        {
            width: "80px",
            title: colTitle6,
            buttons: [
                {commandName: "edit", caption: "Edit"},
                {commandName: "delete", caption: "Delete"}
            ]
        }
    ];
}

function tableEditing() {
    table.editing = {
        enabled: true,
        event: "click",
        type: "row",
        confirmation: {
            "delete": {
                enabled: true,
                template: function (item) {
                    return "Are you sure you want to delete this transactions?";
                }
            }
        }
    };
}

function tableTool() {
    table.toolbar = [
        {
            buttons: [
                {commandName: "insert", caption: 'Add transaction'}
            ],
            position: "top"
        }
    ];
}

function tableExportOptions() {
    var filename = 'members';
    table.exportOptions = {
        proxy: "/filesaver/save",
        excel: {
            fileName: filename,
            author: "Auag-application",
            dataSource: {remote: {
                    read: {
                        url: urlTableRead,
                        type: "post",
                        dataType: "json"}
                }
            },
            readDataSource: true
        }
    };
}

function dropdownMenu(cell, item) {
    $('<div id="dropdown"/>')
            .appendTo(cell)
            .shieldDropDown({
                dataSource: {
                    data: memberIds
                },
                value: !item[colName7] ? null : item[colName7].toString()
            }).swidget().focus();
}

