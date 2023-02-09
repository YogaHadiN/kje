search();
panggil();
function panggil() {
    var tanggal = $("#form_tanggal").val();
    var staf_id = $("#form_staf_id").val();
    var gaji_pokok = $("#form_gaji_pokok").val();
    var bonus = $("#form_bonus").val();
    var pph21 = $("#form_pph21").val();
    console.log("============================================");
    console.log(tanggal, staf_id, gaji_pokok, bonus, pph21);
    console.log("============================================");
}
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
    var url = "/pembayaran_gaji_karyawan/ajax";
    $.get(
        base + url,
        {
            tanggal: $("#form_tanggal").val(),
            staf_id: $("#form_staf_id").val(),
            gaji_pokok: $("#form_gaji_pokok").val(),
            bonus: $("#form_bonus").val(),
            pph21: $("#form_pph21").val(),
            gaji_netto: $("#form_gaji_netto").val(),
            displayed_rows: $("#displayed_rows").val(),
            key: key,
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (var i = 0; i < data.data.length; i++) {
                temp += "<tr>";
                temp += '<td nowrap class="tanggal">';
                temp += data.data[i].tanggal_dibayar;
                temp += "</a>";
                temp += "</td>";
                temp += '<td nowrap class="nama_staf">';
                temp += data.data[i].nama_staf;
                temp += "</td>";
                temp += '<td class="gaji_pokok uang">';
                temp += uang(data.data[i].gaji_pokok);
                temp += "</td>";
                temp += '<td class="bonus uang">';
                temp += uang(data.data[i].bonus);
                temp += "</td>";
                temp += '<td class="pph21 uang">';
                temp += uang(data.data[i].pph21);
                temp += "</td>";
                temp += '<td class="netto uang">';
                temp += uang(data.data[i].gaji_pokok - data.data[i].pph21);
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
