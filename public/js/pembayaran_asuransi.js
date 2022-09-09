cariPembayaranAsuransi();
var timeout;
var tempRiwayatHutang = "";
var length = $("#table_pembayaran_asuransi").find("thead").find("th").length;
function clearAndSearch(key = 0) {
    $("#pembayaran_asuransi_container").html(
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
        cariPembayaranAsuransi(key);
    }, 600);
}

$(function () {
    var session_print = $("#session_print").val();
    if ($("#print").length > 0) {
        window.open(
            base + "/pdfs/pembayaran_asuransi/" + session_print,
            "_blank"
        );
    }
});

function dummySubmit() {
    if (validatePass()) {
        $("#submit").click();
    }
}

function cariPembayaranAsuransi(key = 0) {
    var pages;
    var id = $("#table_pembayaran_asuransi").find(".id").val();
    var created_at = $("#table_pembayaran_asuransi").find(".created_at").val();
    var nama_asuransi = $("#table_pembayaran_asuransi")
        .find(".nama_asuransi")
        .val();
    var awal_periode = $("#table_pembayaran_asuransi")
        .find(".awal_periode")
        .val();
    var akhir_periode = $("#table_pembayaran_asuransi")
        .find(".akhir_periode")
        .val();
    var pembayaran = $("#table_pembayaran_asuransi").find(".pembayaran").val();
    var tanggal_pembayaran = $("#table_pembayaran_asuransi")
        .find(".tanggal_pembayaran")
        .val();
    var tujuan_kas = $("#table_pembayaran_asuransi").find(".tujuan_kas").val();

    $.get(
        base + "/pendapatans/pembayaran_asuransi/cari_pembayaran",
        {
            id: id,
            created_at: created_at,
            nama_asuransi: nama_asuransi,
            awal_periode: awal_periode,
            akhir_periode: akhir_periode,
            pembayaran: pembayaran,
            displayed_rows: $("#displayed_rows").val(),
            tanggal_pembayaran: tanggal_pembayaran,
            tujuan_kas: tujuan_kas,
            key: key,
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            if (data.data.length > 0) {
                for (var i = 0; i < data.data.length; i++) {
                    temp += "<tr>";
                    temp += '<td class="pembayaran_asuransi_id">';
                    temp += data.data[i].id;
                    temp += "</td>";
                    temp += "<td>";
                    temp += data.data[i].created_at;
                    temp += "</td>";
                    temp += '<td class="nama_asuransi">';
                    temp += data.data[i].nama_asuransi;
                    temp += "</td>";
                    temp += "<td>";
                    temp += data.data[i].awal_periode;
                    temp += "</td>";
                    temp += "<td>";
                    temp += data.data[i].akhir_periode;
                    temp += "</td>";
                    temp += '<td class="text-right">';
                    temp += uang(data.data[i].pembayaran);
                    temp += "</td>";
                    temp += '<td class="tanggal_pembayaran">';
                    temp += data.data[i].tanggal_pembayaran;
                    temp += "</td>";
                    temp += "";
                    temp += "<td>";
                    temp +=
                        '<a type="button" class="btn btn-primary btn-sm" href="' +
                        base +
                        "/pembayaran_asuransis/" +
                        data.data[i].id +
                        '" >Detail</button>';
                    temp += "</td>";
                    temp += "</tr>";
                }
            } else {
                temp += "<tr>";
                temp += '<td class="text-center" colspan=' + length + ">";
                temp += "Tidak ada data untuk ditampilkan";
                temp += "</td>";
                temp += "</tr>";
            }
            $("#pembayaran_asuransi_container").html(temp);
            $("#rows").html(data.rows);
            pages = data.pages;
            if (data.data.length) {
                $("#paging").twbsPagination({
                    startPage: parseInt(key) + 1,
                    totalPages: pages,
                    visiblePages: 7,
                    onPageClick: function (event, page) {
                        cariPembayaranAsuransi(parseInt(page) - 1);
                    },
                });
            }
        }
    );
}
function deletePembayaranAsuransi(control) {
    var pembayaran_asuransi_id = $(control)
        .closest("tr")
        .find(".pembayaran_asuransi_id")
        .html();
    var nama_asuransi = $(control).closest("tr").find(".nama_asuransi").html();
    var tanggal_pembayaran = $(control)
        .closest("tr")
        .find(".tanggal_pembayaran")
        .html();
    console.log(pembayaran_asuransi_id);
    console.log(nama_asuransi);
    console.log(tanggal_pembayaran);
    if (
        confirm(
            "Anda yakin mau menghapus pembayaran " +
                pembayaran_asuransi_id +
                " untuk asuransi " +
                nama_asuransi +
                " yang dibayarkan pada tanggal " +
                tanggal_pembayaran
        )
    ) {
        $.post(
            base + "/pendapatans/pembayaran/asuransi/delete",
            { pembayaran_asuransi_id: pembayaran_asuransi_id },
            function (data, textStatus, jqXHR) {
                data = parseInt($.trim(data));
                if (data == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ada kesalahan, Tidak Bisa Dihapus",
                    });
                } else {
                    Swal.fire(
                        "Good job!",
                        "Pembayaran Asuransi Berhasil Dihapus",
                        "success"
                    );
                    // swal('Berhasil','Pembayaran asuransi ' + pembayaran_asuransi_id + ' berhasil direset', 'success' );
                    // $(control).closest('tr').css('background', 'red');
                    $(control)
                        .closest("tr")
                        .children("td")
                        .animate({ padding: 0 })
                        .wrapInner("<div />")
                        .children()
                        .fadeOut(function () {
                            $(this).closest("tr").remove();
                        });
                }
            }
        );
    }
}
function datafunction(item, index) {
    for (let i = 0, len = item.length; i < len; i++) {
        tempriwayathutang += "<tr>";
        if (iseven(indexriwayathutang)) {
            tempriwayathutang += '<td rowspan="2">' + index + "</td>";
            tempriwayathutang += "<td>2 mg kedua</td>";
        } else {
            tempriwayathutang += "<td>2 mg pertama</td>";
        }
        tempriwayathutang += '<td class="uang">' + item[i].piutang + "</td>";
        tempriwayathutang +=
            '<td class="uang">' + item[i].sudah_dibayar + "</td>";
        tempriwayathutang +=
            '<td class="uang">' +
            (parseint(item[i].piutang) - parseint(item[i].sudah_dibayar)) +
            "</td>";
        tempriwayathutang += "</tr>";
    }
}
