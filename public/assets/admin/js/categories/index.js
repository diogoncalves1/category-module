$(function () {
    $("#table").DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        ordering: true,
        searching: true,
        processing: true,
        serverSide: true,
        columnDefs: [
            {
                orderable: false,
                targets: [2, 3],
            },
        ],
        ajax: {
            url: "/api/categories/data",
            type: "GET",
            dataSrc: function (json) {
                console.log(json);
                return json.data;
            },
        },
        columns: [
            {
                data: "name",
                render(h, xhr, data) {
                    return `<i style="color: ${data.color}" class="${data.icon}"></i> ${h}`;
                },
            },
            {
                data: "type",
            },
            {
                data: "parentName",
            },
            {
                data: "actions",
            },
        ],
    });
});
