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
        var token = $('meta[name="csrf-token"]').attr("content");
        for (var i = 0; i < data.length; i++) {
            temp += "<tr>";
            temp += "<td>" + data[i].id + "</td>";
            temp += "<td>" + data[i].tanggal + "</td>";
            temp += "<td>" + data[i].nama_dokter + "</td>";
            temp +=
                "<td class='text-right'>" + uang(data[i].pembayaran) + "</td>";
            temp += "<td>";
            temp +=
                '<form method="POST" action="' +
                base +
                "/bayar_gajis/" +
                data[i].id +
                '" accept-charset="UTF-8"> <input name="_method" type="hidden" value="DELETE" autocomplete="off"> <input name="_token" type="hidden" value="' +
                token +
                '" autocomplete="off">';
            temp +=
                " <a class='btn btn-info btn-xs' href='" +
                base +
                "/pdfs/bayar_gaji_karyawan/" +
                data[i].id +
                "' target='_blank'>Struk</a>";
            temp +=
                '<input class="btn btn-danger btn-xs ml-6" onclick="return confirm(\'Anda yakin mau menghapus gaji ' +
                data[i].nama_dokter +
                " pada tanggal " +
                data[i].tanggal +
                " dengan id " +
                data[i].id +
                '?\');return false;" type="submit" value="Delete" autocomplete="off">';
            temp += "</form>";
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
