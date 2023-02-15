search();
var auth_id = $("#auth_id").val();
var csrf_token = $('meta[name="csrf-token"]').attr("content");
var timeout;
var length = $("#container").closest("table").find("thead").find("th").length;
function clearAndSearch(key = 0) {
    $("#container").html(
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
    var staf_id = $("#staf_id").val();
    var url = "/stafs/" + staf_id + "/search/gaji";
    $.get(
        base + url,
        {
            staf_id: $("#staf_id").val(),
            nama: $("#nama").val(),
            gaji_pokok: $("#gaji_pokok").val(),
            pph21: $("#pph21").val(),
            displayed_rows: $("#displayed_rows").val(),
            key: key,
        },
        function (data, textStatus, jqXHR) {
            // Tanggal Dibayar
            // Gaji Pokok
            // Bonus
            // Pph21
            // Gaji Netto
            // </th>
            var temp = "";
            for (var i = 0; i < data.data.length; i++) {
                temp += "<tr>";
                temp += '<td nowrap class="tanggal_dibayar">';
                temp += data.data[i].tanggal_dibayar;
                temp += "</td>";
                temp += '<td class="gaji_pokok uang">';
                temp += uang(data.data[i].gaji_pokok);
                temp += "</td>";
                temp += '<td class="bonus uang">';
                temp += uang(data.data[i].bonus);
                temp += "</td>";
                temp += '<td class="gaji_netto uang">';
                temp += uang(
                    parseInt(data.data[i].gaji_pokok) +
                        parseInt(data.data[i].bonus) -
                        parseInt(data.data[i].pph21)
                );
                temp += "</td>";
                temp += '<td class="pph21 uang">';
                temp += uang(data.data[i].pph21);
                temp += "</td>";
                temp += "</tr>";
            }
            $("#container").html(temp);
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
