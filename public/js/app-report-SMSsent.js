$(document).ready(function(){
     var tableColumns = [
        {field: "SendingDateTime", title: "Date time", width: "50px"},
        {field: "DestinationNumber", title: "Sent to", width: "50px"},
        {field: "TextDecoded", title: "Text Message", width: "80px"}
    ];
    
    $('#content_table').show();
    
    $.ajax({
        method: 'GET',
        url: urlRead
    }).done(function (tableData) {
        createTableReadOnly(tableData, tableColumns);
    });
});


