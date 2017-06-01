$(document).ready(function () {

    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    var schemaFields = {
        id: {path: "id", type: Number},
        firstname: {path: "firstname", type: String},
        lastname: {path: "lastname", type: String},
        phonenumber: {path: "phonenumber", type: String}
    };

    var tableColumns = [
        {field: "firstname", title: "Firstname", width: "50px"},
        {field: "lastname", title: "Lastname", width: "50px"},
        {field: "phonenumber", title: "Phonenumber", width: "80px"},
        {
            width: "104px",
            title: "Edit/Delete command",
            buttons: [
                {commandName: "edit", caption: "Edit"},
                {commandName: "delete", caption: "Delete"}
            ]
        }
    ];

    var dataCreate = function (edited) {
        return {
            firstname: edited[0].data.firstname,
            lastname: edited[0].data.lastname,
            phonenumber: edited[0].data.phonenumber
        };
    };
    var dataModify = function (edited) {
        return {
            id: edited[0].data.id,
            firstname: edited[0].data.firstname,
            lastname: edited[0].data.lastname,
            phonenumber: edited[0].data.phonenumber
        };
    };
    var dataRemove = function (removed) {
        return {id: removed[0].data.id};
    };
    var templateDelete = function (item) {
        return "Are you sure you want to delete '" + item.firstname + "'?";
    };

    createTableCRUD(urlRead, urlCreate, urlUpdate, urlRemove,
    schemaFields, dataCreate, dataModify, dataRemove, tableColumns, 
        templateDelete);

//    function onPostClick(event)
//    {
//        // we're passing data with the post route, as this is more normal
//        $.post(urlUpdate, {'data': 'This is member', _token: token}, onSuccess);
//    }
//
//    function onSuccess(data, status, xhr)
//    {
//        // with our success handler, we're just logging the data...
//        console.log(JSON.stringify(data));
//    }
//    $('button#memberUpdate').on('click', onPostClick);

});



