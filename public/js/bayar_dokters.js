view();
function view(key = 0) {
    var nama_dokter = $("#nama_dokter").val();
    var tanggal = $("#tanggal").val();
    var pembayaran = $("#pembayaran").val();

    var displayed_rows = $("#displayed_rows").val();
    var param = {
        pembayaran: pembayaran,
        tanggal: tanggal,
        nama_dokter: nama_dokter,
        displayed_rows: displayed_rows,
        key: key,
    };
    console.log("param", param, "base", base);
    $.get(base + "/bayardokters/select/ajax", param, function (hasil) {
        var data = hasil.data;
        var pages = hasil.pages;
        var key = hasil.key;
        var rows = hasil.rows;
        var temp = "";
        for (var i = 0; i < data.length; i++) {
            temp += "<tr>";
            temp += "<td>" + data[i].id + "</td>";
            temp += "<td>" + data[i].tanggal + "</td>";
            temp += "<td>" + data[i].nama_dokter + "</td>";
            temp +=
                "<td class='text-right'>" + uang(data[i].pembayaran) + "</td>";
            temp +=
                "<td><a class='btn btn-info btn-xs' href='" +
                base +
                "/pdfs/bayar_gaji_karyawan/" +
                data[i].id +
                "' target='_blank'>Struk</a></td>";
            temp += "</tr>";
        }
        $("#content").html(temp);
        if (data.length) {
            $("#paging").twbsPagination({
                startPage: parseInt(key) + 1,
                totalPages: pages,
                visiblePages: 7,
                onPageClick: function (event, page) {
                    view(parseInt(page) - 1);
                },
            });
        }
        $("#rows_found").html(numeral(rows).format("0,0"));
    });
}
function clearAndView(key = 0) {
    if ($("#paging").data("twbs-pagination")) {
        $("#paging").twbsPagination("destroy");
    }
    view(key);
}
