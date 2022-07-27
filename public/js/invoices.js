getData();
function getData() {
    var asuransi_id = $("#asuransi_id").val();
    var kode_invoice = $("#kode_invoice").val();
    var tanggal = $("#tanggal").val();
    var piutang = $("#piutang").val();
    var sudah_dibayar = $("#sudah_dibayar").val();
    var sisa = $("#sisa").val();

    $.get(
        "/invoices/getData",
        {
            asuransi_id: asuransi_id,
            tanggal: tanggal,
            piutang: piutang,
            sudah_dibayar: sudah_dibayar,
            sisa: sisa,
            kode_invoice: kode_invoice,
        },
        function (data, textStatus, jqXHR) {
            var temp = "";

            for (let i = 0, len = data.length; i < len; i++) {
                var total_sudah_dibayar = 0;
                if (data[i].sudah_dibayar !== null) {
                    total_sudah_dibayar = data[i].total_sudah_dibayar;
                }
                temp += "<tr>";
                temp += "<td nowrap>";
                temp += data[i].tanggal;
                temp += "</td>";
                temp += "<td nowrap>";
                temp += data[i].kode_invoice;
                temp += "</td>";
                temp += "<td nowrap>";
                temp += data[i].nama_asuransi;
                temp += "</td>";
                temp += '<td class="uang">';
                temp += data[i].total_piutang;
                temp += "</td>";
                temp += '<td class="uang">';
                temp += total_sudah_dibayar;
                temp += "</td>";
                temp += '<td class="uang">';
                temp += data[i].total_piutang - total_sudah_dibayar;
                temp += "</td>";
                temp += "<td nowrap>";
                temp +=
                    '<a class="btn btn-info btn-sm" href="' +
                    base +
                    "/invoices/" +
                    data[i].kode_invoice.replace(/\//g, "!") +
                    '" target="_blank">Show</a>';
                temp += "</td>";
                temp += "</tr>";
            }
            $("#invoices_data").html(temp);
            $("#invoices_data")
                .find(".uang")
                .each(function () {
                    var content = $(this).html();
                    if (content == null) {
                        return "";
                    }
                    var number = content;
                    number = number
                        .toString()
                        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
                    number = "Rp. " + number.trim();
                    $(this).html(number);
                });
        }
    );
}
