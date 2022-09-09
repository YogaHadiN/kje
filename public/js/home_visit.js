searchAjax();
var key;
var pages;
function searchAjax(key = 0) {
    var nama = $("#nama").val();
    var tanggal = $("#tanggal").val();
    var displayed_rows = $("#displayed_rows").val();

    $.get(
        base + "/home_visits/ajax/angka_kontak_bpjs",
        {
            nama: nama,
            tanggal: tanggal,
            displayed_rows: displayed_rows,
            key: key,
        },
        function (result, textStatus, jqXHR) {
            data = result.data;
            key = result.key;
            pages = result.pages;
            rows = result.rows;

            var temp = "";
            if (data.length > 0) {
                for (var i = 0, len = data.length; i < len; i++) {
                    temp += "<tr>";
                    temp += '<td class="tanggal">';
                    temp += data[i].tanggal;
                    temp += "</td>";
                    temp += '<td class="nama">';
                    temp += data[i].nama;
                    temp += "</td>";
                    temp += '<td class="nomor_asuransi_bpjs">';
                    temp += data[i].nomor_asuransi_bpjs;
                    temp += "</td>";
                    temp += '<td class="tekanan_darah">';
                    temp +=
                        data[i].sistolik + "/" + data[i].diastolik + " mmHg";
                    temp += "</td>";
                    temp += '<td class="berat_badan">';
                    temp += data[i].berat_badan;
                    temp += "</td>";
                    temp += '<td class="action">';
                    temp +=
                        '<a href="' +
                        base +
                        "/home_visits/" +
                        data[i].id +
                        '/edit" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-edit"></span></button>';
                    temp += "</td>";
                    temp += "</tr>";
                }
            } else {
                var colspan = $("#ajax_container")
                    .closest("table")
                    .find("th").length;
                temp += "<tr>";
                temp += '<td colspan="' + colspan + '" class="text-center">';
                temp += "Tidak ada data untuk ditampilkan";
                temp += "</td>";
                temp += "</tr>";
            }
            $("#ajax_container").html(temp);
            $("#paging").twbsPagination({
                startPage: parseInt(key) + 1,
                totalPages: pages,
                visiblePages: 7,
                onPageClick: function (event, page) {
                    searchAjax(parseInt(page) - 1);
                },
            });
            $("#rows").html(numeral(rows).format("0,0"));
        }
    );
}
function clearAndSelect(key = 0) {
    if ($("#paging").data("twbs-pagination")) {
        $("#paging").twbsPagination("destroy");
    }
    searchAjax(key);
}
var timeout;
$("body").on("keyup", ".ajaxselect", function () {
    loaderGif();
    window.clearTimeout(timeout);
    timeout = window.setTimeout(function () {
        clearAndSelect();
        console.log("exec");
    }, 600);
});

function loaderGif() {
    var colspan = $("#ajax_container")
        .closest("table")
        .find("thead tr")
        .find("th:not(.displayNone)").length;
    $("#ajax_container").html(
        "<td colspan='" +
            colspan +
            "'><img class='loader' src='" +
            base_s3 +
            "/img/loader.gif' /></td>"
    );
}
