renderDocuments();
function renderDocuments(key = 0) {
    $.get(
        base + "/sertifikats/search",
        {
            id: $("#id").val(),
            nama: $("#nama").val(),
            staf_id: $("#staf_id").val(),
            tanggal_terbit: $("#tanggal_terbit").val(),
            expiry_date: $("#expiry_date").val(),
            displayed_rows: $("#displayed_rows").val(),
            expiry_date: $("#expiry_date").val(),
            key: key,
        },
        function (data, textStatus, jqXHR) {
            view(data, key);
        }
    );
}
function del(control) {
    var id = $(control).closest("tr").find(".id").html();
    if (confirm("Anda yakin mau menghapus data ini?")) {
        $.post(
            base + "/sertifikats/ajax/delete",
            {
                id: id,
            },
            function (data, textStatus, jqXHR) {
                if (data) {
                    renderDocuments(0);
                }
            }
        );
    }
}

function documentKeyUp(key = 0) {
    if ($("#paging").data("twbs-pagination")) {
        $("#paging").twbsPagination("destroy");
    }
    renderDocuments(key);
}

function view(data, key) {
    var temp = "";
    if (data.data.length > 0) {
        for (let i = 0, len = data.data.length; i < len; i++) {
            var loc = base_s3 + "/" + data.data[i].url;
            console.log("log", loc);
            temp += "<tr>";
            temp += "<td class='id'>";
            temp += data.data[i].id;
            temp += "</td>";
            temp += "<td>";
            temp += data.data[i].nama;
            temp += "</td>";
            temp += "<td>";
            temp += data.data[i].nama_staf;
            temp += "</td>";
            temp += "<td>";
            temp += data.data[i].tanggal_terbit;
            temp += "</td>";
            temp += "<td class='text-center'>";
            temp += data.data[i].expiry_date ? data.data[i].expiry_date : "-";
            temp += "</td>";
            temp += "<td nowrap>";
            temp +=
                "<a href='" +
                loc +
                "' class='btn btn-success btn-sm' target='_blank'><span class='glyphicon glyphicon-download-alt'></span></a> ";
            temp +=
                '<a href="' +
                base +
                "/sertifikats/" +
                data.data[i].id +
                "/edit" +
                '" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-edit"></span></a>';
            temp += "</td>";
            temp += "</tr>";
        }
        $("#paging").twbsPagination({
            startPage: parseInt(key) + 1,
            totalPages: data.pages,
            visiblePages: 7,
            onPageClick: function (event, page) {
                renderDocuments(parseInt(page) - 1);
            },
        });
    } else {
        temp += "<tr>";
        temp += '<td colspan="6" class="warning text-center">';
        temp += "Tidak ada data untuk ditampilkan";
        temp += "</td>";
        temp += "</tr>";
        $("#paging").html("");
    }
    $("#container").html(temp);
}
