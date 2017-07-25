
function createTable() {
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

    table = {dataSource: {
            events: {
                error: function (event) {
                    if (event.errorType === "transport") {
                        // transport error is an ajax error; event holds the xhr object
                        var responseJson = JSON.parse(event.error.responseText);
                        if (responseJson.response === true) {
                            //alert('Successfull saved');
                        } else {
                            alert(event.error.responseText);
                        }

                        // reload the data source if the operation that failed was save
                        if (event.operation === "save") {
                            //this.read();
                        }
                    } else {
                        // other data source error - validation, etc
                        alert(event.errorType + " error: " + event.error);
                    }
                    this.read();
                }
            },
            remote: {
                read: {
                    url: urlTableRead,
                    type: "post",
                    dataType: "json"
                },
                modify: {
                    create: function (items, success, error) {
                        var newItem = items[0];
                        $.ajax({
                            type: "post",
                            url: urlTableAdd,
                            dataType: "json",
                            data: newItem.data,
                            complete: function (xhr) {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 201) {
                                        // update the id of the newly-created item with the 
                                        // one returned from the server in the Location hader url
                                        var location = xhr.getResponseHeader("Location");
                                        newItem.data.Id = +location.replace(/^.*?\/([\d]+)$/, "$1");
                                        success();
                                        return;
                                    }
                                }
                                error(xhr);
                            }
                        });
                    },
                    update: function (items, success, error) {
                        $.ajax({
                            type: "post",
                            url: urlTableUpdate,
                            dataType: "json",
                            data: items[0].data,
                            complete: function (xhr) {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 201) {
                                        // update the id of the newly-created item with the 
                                        // one returned from the server in the Location hader url
                                        var location = xhr.getResponseHeader("Location");
                                        newItem.data.Id = +location.replace(/^.*?\/([\d]+)$/, "$1");
                                        success();
                                        return;
                                    }
                                }
                                error(xhr);
                            }
                        });
                    },
                    remove: function (items, success, error) {
                        $.ajax({
                            type: "post",
                            url: urlTableDelete,
                            dataType: "json",
                            data: items[0].data,
                            complete: function (xhr) {
                                if (xhr.readyState == 4) {
                                    if (xhr.status == 201) {
                                        // update the id of the newly-created item with the 
                                        // one returned from the server in the Location hader url
                                        var location = xhr.getResponseHeader("Location");
                                        newItem.data.Id = +location.replace(/^.*?\/([\d]+)$/, "$1");
                                        success();
                                        return;
                                    }
                                }
                                error(xhr);
                            }
                        });
                    }
                }
            },
            schema: {
                fields: null
            }
        },
        paging: true,
        sorting: {
            multiple: true
        },
        rowHover: false,
        columns: null,
        editing: {
            enabled: true,
            event: "doubleclick",
            type: "row",
            confirmation: {
                "delete": {
                    enabled: true,
                    template: function (item) {
                        return "Are you sure you want to delete?";
                    }
                }
            }
        },
        scrolling: true,
        resizing: true,
        toolbar: [
            {
                buttons: [
                    
                ]
            }
        ],
        exportOptions: null,
        events: {
            columnResize: function (e) {
                console.log("Resized " + e.field + " to " + e.width);
            },
            getCustomEditorValue: function (e) {
                    e.value = $("#dropdown").swidget().value();
                    $("#dropdown").swidget().destroy();
                }
        }
    };
}

function searchfield(column_to_filter) {
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
                        {path: columnNames[0], filter: "contains", value: value},
                        {path: columnNames[1], filter: "contains", value: value},
                        {path: columnNames[2], filter: "contains", value: value},
                        {path: columnNames[3], filter: "contains", value: value}
                    ]
                };
            } else {
                dataSource.filter = null;
            }
            dataSource.read();
        }, 300);
    });
}

