$(document).ready(function () {

    $('#content_table').show();
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    var schemaFields = {
        id: {path: "id", type: Number},
        code: {path: "code", type: String},
        description: {path: "description", type: String},
        members_col: {path: "members_col", type: String},
        message: {path: "message", type: String}
    };

    var tableColumns = [
        {field: "code", title: "Code", width: "50px"},
        {field: "description", title: "Description", width: "50px"},
        {field: "members_col", title: "Members column", width: "80px"},
        {field: "message", title: "Message", width: "80px"},
        {
            width: "104px",
            title: "Edit/Delete",
            buttons: [
                {commandName: "edit", caption: "Edit"},
                {commandName: "delete", caption: "Delete"}
            ]
        }
    ];

    var dataCreate = function (edited) {
        return {
            code: edited[0].data.code,
            description: edited[0].data.description,
            members_col: edited[0].data.members_col,
            message: edited[0].data.message
        };
    };
    var dataModify = function (edited) {
        return {
            id: edited[0].data.id,
            code: edited[0].data.code,
            description: edited[0].data.description,
            members_col: edited[0].data.members_col,
            message: edited[0].data.message
        };
    };
    var dataRemove = function (removed) {
        return {id: removed[0].data.id};
    };
    var templateDelete = function (item) {
        return "Are you sure you want to delete '" + item.code + "'?";
    };

    createTableCRUD(urlRead, urlCreate, urlUpdate, urlRemove,
    schemaFields, dataCreate, dataModify, dataRemove, tableColumns, 
        templateDelete);


});



