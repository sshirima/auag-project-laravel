function createTableCRUD(urlRead, urlCreate, urlUpdate, urlRemove,
        schemaFields, dataCreate, dataModify, dataRemove, tableColumns,
        templateDelete) {

    $("#table-view").shieldGrid({
        dataSource: {
            remote: {
                read: {
                    url: urlRead,
                    type: "post",
                    dataType: "json"
                },
                modify: {
                    create: {
                        url: urlCreate,
                        type: "post",
                        dataType: "json",
                        data: dataCreate
                    },
                    update: {
                        url: urlUpdate,
                        type: "post",
                        dataType: "json",
                        data: dataModify
                    },
                    remove: {
                        url: urlRemove,
                        type: "post",
                        data: dataRemove
                    }
                }
            },
            schema: {

                fields: schemaFields
            }
        },
        paging: true,
        sorting: {
            multiple: true
        },
        rowHover: false,
        columns: tableColumns,
        editing: {
            enabled: true,
            event: "click",
            type: "row",
            confirmation: {
                "delete": {
                    enabled: true,
                    template: templateDelete
                }
            }
        },
        toolbar: [
            {
                buttons: [
                    {commandName: "insert", caption: "Add"}
                ],
                position: "top"
            }
        ]
    });
}

function createTableReadOnly(tableData, tableColumns) {
    $("#table-view").shieldGrid({
        dataSource: {
            data: tableData
        },
        paging: true,
        selection: {
            type: "row",
            multiple: true,
            toggle: false
        },
        sorting: {
            multiple: true
        },
        rowHover: false,
        columns: tableColumns
    });
}