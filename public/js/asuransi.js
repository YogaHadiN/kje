viewTarif();
function viewTarif() {
    $.get(
        base + "/asuransis/get/tarifs/" + $("#asuransi_id").val(),
        {
            jenis_tarif_id: $("#sp_jenis_tarif_id").val(),
            biaya: $("#sp_biaya").val(),
            jasa_dokter: $("#sp_jasa_dokter").val(),
            tipe_tindakan_id: $("#sp_tipe_tindakan_id").val(),
        },
        function (data, textStatus, jqXHR) {
            var temp = "";

            console.log("data", data);
            for (let i = 0, len = data.length; i < len; i++) {
                temp += "<tr>";
                temp += "<td class='jenis_tarif'>";
                temp += data[i].jenis_tarif;
                temp += "</td>";
                temp += "<td class='biaya'>";
                temp += uang(Math.floor(data[i].biaya));
                temp += "</td>";
                temp += "<td class='jasa_dokter'>";
                temp += uang(Math.floor(data[i].jasa_dokter));
                temp += "</td>";
                temp += "<td class='tipe_tindakan'>";
                temp += data[i].tipe_tindakan;
                temp += "</td>";
                temp += "<td class='id hide'>";
                temp += data[i].tarif_id;
                temp += "</td>";
                temp += "<td class='key hide'>";
                temp += i;
                temp += "</td>";
                temp += "<td class='tipe_tindakan_id hide'>";
                temp += data[i].tipe_tindakan_id;
                temp += "</td>";
                temp += "<td class='action'>";
                temp +=
                    '<a href="' +
                    base +
                    "/asuransis/" +
                    $("#asuransi_id").val() +
                    "/tarifs/" +
                    data[i].tarif_id +
                    '" class="btn btn-warning btn-sm">Edit</button>';
                temp += "</td>";
                temp += "</tr>";
            }

            $("#tarifContainer").html(temp);
        }
    );
}
