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
            url: "/api/categories/data-user",
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

const updateRates = document.getElementById("updateRates");

updateRates.addEventListener("click", tryUpdateRates);

async function tryUpdateRates() {
    var url = "/api/currencies/update-rates";

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            successToast(response.message);
            $("#table").DataTable().ajax.reload();
        },
        error: function (error) {
            console.log(error);

            errorToast(error.responseJSON.message);
        },
    });
}
