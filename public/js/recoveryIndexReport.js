search();
var auth_id = $("#auth_id").val();
var csrf_token = $('meta[name="csrf-token"]').attr("content");
var timeout;
var length = $("#rek_container")
    .closest("table")
    .find("thead")
    .find("th").length;
function clearAndSearch(key = 0) {
    $("#rek_container").html(
        "<tr><td colspan='" +
            length +
            "' class='text-center'><img class='loader' src='" +
            base_s3 +
            "/img/loader.gif'></td></tr>"
    );
    window.clearTimeout(timeout);
    timeout = window.setTimeout(function () {
        if ($("#paging").data("twbs-pagination")) {
            $("#paging").twbsPagination("destroy");
        }
        search(key);
    }, 600);
}
function search(key = 0) {
    var pages;
    var url = "/recoveryIndexReport/ajax";
    $.get(
        base + url,
        {
            recovery_index_id: $("#recovery_index_id").val(),
            tanggal: $("#tanggal").val(),
            staf_id: $("#staf_id").val(),
            nama: $("#nama").val(),
            asuransi_id: $("#asuransi_id").val(),
            keluhan: $("#keluhan").val(),
            displayed_rows: $("#displayed_rows").val(),
            key: key,
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (var i = 0; i < data.data.length; i++) {
                temp += "<tr>";
                temp += '<td nowrap class="kolom_tanggal">';
                temp +=
                    '<a href="' +
                    base +
                    "/periksas/" +
                    data.data[i].periksa_id +
                    '" target="_blank">';
                temp += data.data[i].tanggal;
                temp += "</a>";
                temp += "</td>";
                temp += '<td nowrap class="kolom_nama">';
                temp +=
                    '<a href="' +
                    base +
                    "/pasiens/" +
                    data.data[i].pasien_id +
                    '/edit" target="_blank">';
                temp += data.data[i].nama;
                temp += "</a>";
                temp += "</td>";
                temp += '<td class="kolom_dokter">';
                temp += data.data[i].dokter;
                temp += "</td>";
                temp += '<td class="kolom_pembayaran">';
                temp += data.data[i].pembayaran;
                temp += "</td>";
                temp += '<td class="kolom_keluhan">';
                temp += data.data[i].keluhan;
                temp += "</td>";
                temp += "</tr>";
            }
            $("#rek_container").html(temp);
            $("#rows").html(data.rows);
            pages = data.pages;
            if (data.data.length) {
                $("#paging").twbsPagination({
                    startPage: parseInt(key) + 1,
                    totalPages: pages,
                    visiblePages: 7,
                    onPageClick: function (event, page) {
                        search(parseInt(page) - 1);
                    },
                });
            }
        }
    );
}
