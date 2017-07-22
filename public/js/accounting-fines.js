
var table;


$(document).ready(function () {

    field1 = 'field1';
    field2 = 'field2';
    field3 = 'field3';
    field4 = 'field4';
    field5 = 'field5';
    field6 = 'field6';
    field7 = 'field7';
    field8 = 'field8';
    field9 = 'field9';

    colName1 = 'fine_id';
    colName2 = 'fine_account';
    colName3 = 'fine_amount';
    colName4 = 'fine_description';
    colName5 = 'fine_outstanding';
    colName6 = 'fine_paid';
    colName7 = 'created_at';
    colName8 = 'firstname';
    colName9 = 'lastname';

    colTitle1 = 'Share ID';
    colTitle2 = 'Account ID';
    colTitle3 = 'Amount(Tsh)';
    colTitle4 = 'Description';
    colTitle5 = 'Outstanding';
    colTitle6 = 'Paid amount';
    colTitle7 = 'Date created';
    colTitle8 = 'Member name';

    //Get members Ids
    var accountsData = JSON.parse(accounts.replace(/&quot;/g,'"'));

    accountIds = new Array(accountsData.length);
    accountsData.forEach(function(account, index){
        accountIds[index] = account.acc_id;
    });
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
                        colName3 + '": "' + edited[0].data[field3] + '"}');
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
                        colName3 + '": "' + edited[0].data[field3] + '"}');
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
        field5: {path: colName5, type: String},
        field6: {path: colName6, type: String},
        field7: {path: colName7, type: String},
        field8: {path: colName8, type: String},
        field9: {path: colName9, type: String}
    };
}

function tableColumns() {
    table.columns = [
        {field: field8, title: colTitle8, width: "50px"},
        {field: field2, title: colTitle2, width: "50px"},
        {field: field3, title: colTitle3, width: "50px"},
        {field: field4, title: colTitle7, width: "50px"},
        {field: field5, title: colTitle5, width: "50px"},
        {field: field6, title: colTitle6, width: "50px"},
        {field: field7, title: colTitle7, width: "50px"},
    ];
}

function tableEditing() {
    table.editing = {
        enabled: true,
        event: "click",
        type: "row",
        confirmation: {
            
        }
    };
}

function tableTool() {
    table.toolbar = [
        {
            buttons: [
                
            ],
            position: "top"
        }
    ];
}

function tableExportOptions() {
    var filename = 'transactions_shares';
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
                    data: accountIds
                },
                value: !item[colName1] ? null : item[colName1].toString()
            }).swidget().focus();
}
