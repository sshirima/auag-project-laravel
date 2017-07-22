
var table;
var columnNames = new Array('bid_id','bid_shareid','acc_name','bid_price','bid_units','bid_amount','share_currency','created_at');
var columnTitles = new Array('Offer ID','ShareID','Account name','Price@unit','Units','Amount','Currency','Date sold','Edit/Delete');


$(document).ready(function () {
    
     createTable();
    //Important fields
    tableSchemaField();
    tableColumns();
    

    //Tootbar field
    table.toolbar[0].position = 'top';
    table.toolbar[0].buttons[0] = {commandName: "insert", caption: 'Sell shares'};
    //Disable modifying capability
    table.dataSource.remote.modify.update = null;
    //Disable click on the table
    $("#rw_table").shieldGrid(table);

    searchfield();
});

function tableSchemaField() {
    var fields = {};
    for (var i = 0; i < columnNames.length; i++) {
        fields[columnNames[i]] = {path: columnNames[i], type: String};
    }
    table.dataSource.schema.fields = fields;
}

function tableColumns() {
    table.columns = [
        {field: columnNames[1], title: columnTitles[1], width: "50px", editor: dropdownMenu},
        {field: columnNames[5], title: columnTitles[5], width: "50px"},
        {field: columnNames[4], title: columnTitles[4], width: "50px"},
        {field: columnNames[7], title: columnTitles[7], width: "50px"},
        {field: columnNames[2], title: columnTitles[2], width: "50px"},
        {field: columnNames[6], title: columnTitles[6], width: "50px"},
        {
            width: "80px",
            title: columnTitles[8],
            buttons: [
                {commandName: "edit", caption: ""},
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
                    data: JSON.parse(account_share.replace(/&quot;/g, '"')),
                    filter: {
                        and: [
                            {path: "share_id", filter: "contains", value: ""}
                        ]
                    }
                },
                textTemplate: function (item) {
                    return item.acc_name;
                },
                valueTemplate: "{share_id}"
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
                        {path: columnNames[2], filter: "contains", value: value},
                        {path: columnNames[7], filter: "contains", value: value}
                    ]
                };
            } else {
                dataSource.filter = null;
            }
            dataSource.read();
        }, 300);
    });
}

