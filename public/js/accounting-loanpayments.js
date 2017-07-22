
var table;


$(document).ready(function () {

    field1 = 'field1';
    field2 = 'field2';
    field3 = 'field3';
    field4 = 'field4';
    field5 = 'field5';
    field6 = 'field6';
    field7 = 'field7';

    colName1 = 'acc_id';
    colName2 = 'acc_name';
    colName3 = 'loanpay_id';
    colName4 = 'loanpay_loanid';
    colName5 = 'loanpay_amount';
    colName6 = 'created_at';
    colName7 = 'acc_currency';

    colTitle1 = 'Account ID';
    colTitle2 = 'Account name';
    colTitle3 = 'Pay ID';
    colTitle4 = 'Loan ID';
    colTitle5 = 'Amount';
    colTitle6 = 'Date paid';
    colTitle7 = 'Currency';

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
        field7: {path: colName7, type: String}
    };
}

function tableColumns() {
    table.columns = [
        {field: field1, title: colTitle1, width: "30px"},
        {field: field2, title: colTitle2, width: "30px"},
        {field: field3, title: colTitle3, width: "30px"},
        {field: field4, title: colTitle4, width: "30px"},
        {field: field5, title: colTitle5, width: "30px"},
        {field: field6, title: colTitle6, width: "30px"},
        {field: field7, title: colTitle7, width: "30px"}
        
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


