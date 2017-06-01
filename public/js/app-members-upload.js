$(document).ready(function () {

    var tableColumns = [
        {field: "firstname", title: "Firstname", width: "50px"},
        {field: "lastname", title: "Lastname", width: "50px"},
        {field: "phonenumber", title: "Phonenumber", width: "80px"}
    ];

    var membersData = $('#in_member_data').val();
    var urlImport = $('#in_url_import').val();
    var token = $('#in_token').val();

    createTableReadOnly(membersData, tableColumns);

    $('#bt_save_data').on('click', function () {
        $.ajax({
            method: 'POST',
            url: urlImport,
            data: {membersData: membersData, _token: token}

        }).done(function (msg) {
            console.log(JSON.stringify(msg));
            var dataarray = msg.data;
            var ul='';
            if (msg.status === 'success') {
                
                for (var i = 0; i < dataarray.length; i++) {
                    var row = dataarray[i];
                    ul = ul + '<ul> '+row.message+'</ul>';
                }
                $('#dv_save_report').addClass('alert-success').html(ul);
            } else {
                $('#dv_save_report').addClass('alert-danger').html(msg.data);
            }
        });
    });

//    $('#loadMember').on('click', function () {
//        $.ajax({
//            method: 'POST',
//            url: urlLoad,
//            data: {id: $('#id').val(), _token: token}
//        }).done(function (msg) {
//            console.log(JSON.stringify(msg));
//            $('#id').val(msg.id);
//            $('#firstname').val(msg.firstname);
//            $('#lastname').val(msg.lastname);
//            $('#phonenumber').val(msg.phonenumber);
//        });
//    });
//    
//    $('#updateMember').on('click', function (){
//        $.ajax({
//            method:'POST',
//            url: urlUpdate,
//            data:{id:$('#id').val(),firstname:$('#firstname').val(), lastname:$('#lastname').val(),phonenumber:$('#phonenumber').val(),_token:token}
//        }).done(function(msg){
//            console.log(JSON.stringify(msg));
//            $('#id').val(msg.id);
//            $('#firstname').val(msg.firstname);
//            $('#lastname').val(msg.lastname);
//            $('#phonenumber').val(msg.phonenumber);
//        });
//    });
});



