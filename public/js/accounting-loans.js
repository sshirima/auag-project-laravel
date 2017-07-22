
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
    field10 = 'field10';
    field11 = 'field11';

    colName1 = 'loan_id';
    colName2 = 'loan_account';
    colName3 = 'loan_principle';
    colName4 = 'loan_paid';
    colName5 = 'loan_balance';
    colName6 = 'loan_rate';
    colName7 = 'loan_duration';
    colName8 = 'loan_progress';
    colName9 = 'loan_interest';
    colName10 = 'firstname';
    colName11 = 'created_at';

    colTitle10 = 'Member name';
    colTitle3 = 'Principle';
    colTitle4 = 'Amount paid';
    colTitle5 = 'Outstanding';
    colTitle6 = 'Rate';
    colTitle7 = 'Duration(months)';
    colTitle8 = 'Progress';
    colTitle9 = 'Interest';
    colTitle11 = 'Date acquired';

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
        field2: {path: colName2, type: String},
        field3: {path: colName3, type: String},
        field4: {path: colName4, type: String},
        field5: {path: colName5, type: String},
        field6: {path: colName6, type: String},
        field7: {path: colName7, type: String},
        field8: {path: colName8, type: String},
        field10: {path: colName10, type: String},
        field9: {path: colName9, type: String},
        field11: {path: colName11, type: String}
    };
}

function tableColumns() {
    table.columns = [
        {field: field10, title: colTitle10,width:"30px"},
        {field: field3, title: colTitle3, width: "30px"},
        {field: field4, title: colTitle4, width: "30px"},
        {field: field5, title: colTitle5, width: "30px"},
        {field: field6, title: colTitle6, width: "30px"},
        {field: field7, title: colTitle7, width: "30px"},
        {field: field8, title: colTitle8, width: "30px"},
        {field: field9, title: colTitle9, width: "30px"},
        {field: field11, title: colTitle11, width: "50px"}
        
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
                    return "Are you sure you want this loan?";
                }
            }
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


