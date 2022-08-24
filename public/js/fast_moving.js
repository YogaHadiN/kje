refreshLaporan();
function refreshLaporan() {
    var bulanTahun = $("#bulanTahun").val();
    loaderGif("#container");
    $.get(
        base + "/obat/fast_moving/ajax",
        {
            bulanTahun: bulanTahun,
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (let i = 0, len = data.length; i < len; i++) {
                temp += "<tr>";
                temp += "<td>";
                temp += parseInt(i) + 1;
                temp += "</td>";
                temp += "<td>";
                temp += data[i].merek;
                temp += "</td>";
                temp += "<td>";
                temp += data[i].kode_rak;
                temp += "</td>";
                temp += "<td class='text-right'>";
                temp += uang(data[i].harga_beli);
                temp += "</td>";
                temp += "<td class='text-right'>";
                temp += uang(data[i].harga_jual);
                temp += "</td>";
                temp += "<td class='text-right'>";
                temp += data[i].jumlah;
                temp += "</td>";
                temp += "</tr>";
            }
            $("#container").html(temp);
        }
    );
}
