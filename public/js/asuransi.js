var timeout;
clearAndSearch();
function viewTarif(key = 0) {
    $.get(
        base + "/asuransis/search/",
        {
            id: $("#id").val(),
            nama: $("#nama").val(),
            alamat: $("#alamat").val(),
            key: key,
            displayed_rows: $("#displayed_rows").val(),
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (let i = 0, len = data.data.length; i < len; i++) {
                temp += "<tr>";
                temp += "<td class='jenis_tarif'>";
                temp += data.data[i].id;
                temp += "</td>";
                temp += "<td class='biaya'>";
                temp += data.data[i].nama;
                temp += "</td>";
                temp += "<td class='jasa_dokter'>";
                temp += data.data[i].alamat;
                temp += "</td>";
                temp += "<td class='key hide'>";
                temp += i;
                temp += "</td>";
                temp += "<td>";
                temp +=
                    '<a href="' +
                    base +
                    "/asuransis/" +
                    data.data[i].id +
                    "/edit" +
                    '" class="btn btn-warning btn-sm">Edit</button>';
                temp += "</td>";
                temp += "<td>";
                temp +=
                    '<a href="' +
                    base +
                    "/asuransis/" +
                    data.data[i].id +
                    "/hutang/pembayaran" +
                    '" class="btn btn-info btn-sm">Payment History</button>';
                temp += "</td>";
                temp += "<td>";
                temp +=
                    '<a href="' +
                    base +
                    "/asuransis/" +
                    data.data[i].id +
                    "/tarifs" +
                    '" class="btn btn-primary btn-sm">Tarif</button>';
                temp += "</td>";
                temp += "</tr>";
            }

            $("#asuransi_container").html(temp);
            if (data.data.length) {
                pages = data.pages;
                $("#paging").twbsPagination({
                    startPage: parseInt(key) + 1,
                    totalPages: pages,
                    visiblePages: 7,
                    onPageClick: function (event, page) {
                        viewTarif(parseInt(page) - 1);
                    },
                });
            }
            $("#rows").html(numeral(rows).format("0,0"));
        }
    );
}

function clearAndSearch(key = 0) {
    var col_length = $("#asuransi_container")
        .closest("table")
        .find("thead tr:first th").length;
    console.log("col_length", col_length);
    $("#asuransi_container").html(
        "<tr><td colspan='" +
            col_length +
            "' class='text-center'><img class='loader' src='" +
            base_s3 +
            "/img/loader.gif'></td></tr>"
    );
    window.clearTimeout(timeout);
    timeout = window.setTimeout(function () {
        if ($("#paging").data("twbs-pagination")) {
            $("#paging").twbsPagination("destroy");
        }
        viewTarif(key);
    }, 600);
}
