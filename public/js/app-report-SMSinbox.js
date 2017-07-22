$(document).ready(function(){
    var tableColumns = [
        {field: "ReceivingDateTime", title: "Date time", width: "50px"},
        {field: "SenderNumber", title: "Received from", width: "50px"},
        {field: "TextDecoded", title: "Text Message", width: "80px"},
        {field: "Processed", title: "Processed", width: "30px"}
    ];
    
    $('#content_table').show();
    
    $.ajax({
        method: 'GET',
        url: urlRead
    }).done(function (tableData) {
        createTableReadOnly(tableData, tableColumns);
    });
});

