refreshLaporan();
function refreshLaporan() {
    var bulanTahun = $("#bulanTahun").val();
    $("#body").next().remove();
    loaderGif("#body");
    $.get(
        base + "/laporans/dispensing_obat_bpjs/get",
        {
            bulanTahun: bulanTahun,
        },
        function (data, textStatus, jqXHR) {
            console.log("bulanTahun", bulanTahun, "data", data);
            $(".foot").remove();
            var temp = "";
            var total_hpp = 0;
            var total_jumlah_pasien = 0;
            for (let i = 0, len = data.length; i < len; i++) {
                temp += "<tr>";
                temp += "<td>";
                temp += data[i].tanggal;
                temp += "</td>";
                temp += "<td>";
                temp +=
                    "<a href='" +
                    base +
                    "/laporans/dispensing_obat_bpjs/" +
                    data[i].staf_id +
                    "'>";
                temp += data[i].nama_staf;
                temp += "</a>";
                temp += "</td>";
                temp += "<td class='text-right'>";
                temp += uang(data[i].hpp);
                temp += "</td>";
                temp += "<td class='text-right'>";
                temp += data[i].jumlah_pasien;
                temp += "</td>";
                temp += "<td class='text-right'>";
                temp += uang(
                    Math.ceil(
                        parseInt(data[i].hpp) / parseInt(data[i].jumlah_pasien)
                    )
                );
                temp += "</td>";
                temp += "</tr>";

                total_hpp += parseInt(data[i].hpp);
                total_jumlah_pasien += parseInt(data[i].jumlah_pasien);
            }
            $("#body").html(temp);
            var tfoot = "";
            tfoot += "<tfoot class='foot'>";
            tfoot += "<tr>";
            tfoot += "<td colspan='2'>";
            tfoot += "<h3>";
            tfoot += "Total Dispensing Obat";
            tfoot += "</h3>";
            tfoot += "</td>";
            tfoot += "<td class='text-right'>";
            tfoot += "<h3>";
            tfoot += uang(total_hpp);
            tfoot += "</h3>";
            tfoot += "</td>";
            tfoot += "<td class='text-right'>";
            tfoot += "<h3>";
            tfoot += total_jumlah_pasien;
            tfoot += "</h3>";
            tfoot += "</td>";
            tfoot += "<td class='text-right'>";
            tfoot += "<h3>";
            tfoot += uang(
                Math.ceil(parseInt(total_hpp) / parseInt(total_jumlah_pasien))
            );
            tfoot += "</h3>";
            tfoot += "</td>";
            tfoot += "</tr>";
            tfoot += "</tfoot>";
            $("#body").after(tfoot);
        }
    );
}
