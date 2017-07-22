
var table;
var columnNames = new Array('share_id', 'acc_name', 'share_amount', 'updated_at', 'share_units','share_currency');
var columnTitles = new Array('Share ID', 'Account name', 'Share Amount', 'Last purchase', 'Share units', 'Currency');

$(document).ready(function () {

    createTable();
    //Important fields
    table.editing.event = '';
    table.toolbar = [];
    tableSchemaField();
    tableColumns();

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
        {field: columnNames[1], title: columnTitles[1], width: "50px"},
        {field: columnNames[2], title: columnTitles[2], width: "50px"},
        {field: columnNames[4], title: columnTitles[4], width: "50px"},
        {field: columnNames[5], title: columnTitles[5], width: "50px"},
        {field: columnNames[3], title: columnTitles[3], width: "70px"}
    ];
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
                        {path: columnNames[1], filter: "contains", value: value}
                    ]
                };
            } else {
                dataSource.filter = null;
            }
            dataSource.read();
        }, 300);
    });
}
