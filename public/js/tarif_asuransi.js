var timeout;
clearAndSearch();
function viewTarif(key = 0) {
    $.get(
        base + "/asuransis/get/tarifs/" + $("#asuransi_id").val(),
        {
            jenis_tarif_id: $("#sp_jenis_tarif_id").val(),
            biaya: $("#sp_biaya").val(),
            jasa_dokter: $("#sp_jasa_dokter").val(),
            tipe_tindakan_id: $("#sp_tipe_tindakan_id").val(),
            key: key,
            displayed_rows: $("#displayed_rows").val(),
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (let i = 0, len = data.data.length; i < len; i++) {
                temp += "<tr>";
                temp += "<td class='jenis_tarif'>";
                temp += data.data[i].jenis_tarif;
                temp += "</td>";
                temp += "<td class='biaya'>";
                temp += uang(Math.floor(data.data[i].biaya));
                temp += "</td>";
                temp += "<td class='jasa_dokter'>";
                temp += uang(Math.floor(data.data[i].jasa_dokter));
                temp += "</td>";
                temp += "<td class='tipe_tindakan'>";
                temp += data.data[i].tipe_tindakan;
                temp += "</td>";
                temp += "<td class='id hide'>";
                temp += data.data[i].tarif_id;
                temp += "</td>";
                temp += "<td class='key hide'>";
                temp += i;
                temp += "</td>";
                temp += "<td class='tipe_tindakan_id hide'>";
                temp += data.data[i].tipe_tindakan_id;
                temp += "</td>";
                temp += "<td class='action'>";
                temp +=
                    '<a href="' +
                    base +
                    "/asuransis/" +
                    $("#asuransi_id").val() +
                    "/tarifs/" +
                    data.data[i].tarif_id +
                    '" class="btn btn-warning btn-sm">Edit</button>';
                temp += "</td>";
                temp += "</tr>";
            }

            $("#tarifContainer").html(temp);
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
    var col_length = $("#tarifContainer")
        .closest("table")
        .find("thead tr:first th").length;
    console.log("col_length", col_length);
    $("#tarifContainer").html(
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
