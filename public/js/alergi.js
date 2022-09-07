function submitAlergi(control) {
    var pasien_id = $("#pasien_id").val();
    var antrianperiksa_id = $("#antrianperiksa_id").val();
    var selectAlergi = $("#generik_list_alergi").val();
    var param = {
        pasien_id: pasien_id,
        generik_id: selectAlergi,
    };
    $.post(
        base + "/poli/" + antrianperiksa_id + "/alergies",
        param,
        function (data, textStatus, jqXHR) {
            $("#myModal").modal("hide");
            $("#generik_list_alergi").val("");
            $("#generik_list_alergi").selectpicker("refresh");
            if (data["valid"] == "1") {
                var temp = "";
                for (var i = data["alergi"].length - 1; i >= 0; i--) {
                    temp += "<tr>";
                    temp += '<td class="nama_obat">';
                    temp += data["alergi"][i].generik;
                    temp += "</td>";
                    temp += '<td class="nama_obat">';
                    temp +=
                        '<button class="btn btn-danger btn-sm" onclick="deleteAlergi(' +
                        data["alergi"][i].id +
                        ', this);return false;" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>';
                    temp += "</td>";
                    temp += "</tr>";
                }
                $("#alergy_body_table").html(temp);
            } else {
                Swal.fire(
                    "Oops!",
                    "obat yang sama sudah ada di dalam database alergi untuk pasien ini",
                    "error"
                );
            }
        }
    );
}
function deleteAlergi(id, control) {
    var obat = $(control).closest("tr").find(".nama_obat").html();
    var c = confirm(
        "Anda yakin mau menghapus " + obat + " dari daftar alergi pasien ini?"
    );
    if (c) {
        var pasien_id = $("#pasien_id").val();
        var param = {
            alergi_id: id,
            pasien_id: pasien_id,
        };
        $.post(
            base + "/poli/ajax/alergies/delete",
            param,
            function (data, textStatus, jqXHR) {
                $("#myModal").modal("hide");
                var temp = "";
                if (data.length > 0) {
                    for (var i = data.length - 1; i >= 0; i--) {
                        temp += "<tr>";
                        temp += '<td class="nama_obat">';
                        temp += data[i].generik;
                        temp += "</td>";
                        temp += "<td>";
                        temp +=
                            '<button class="btn btn-danger btn-sm" onclick="deleteAlergi(' +
                            data[i].id +
                            ', this);return false;" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</button>';
                        temp += "</td>";
                        temp += "</tr>";
                    }
                } else {
                    temp += '<tr class="text-center">';
                    temp += '<td colspan="2">';
                    temp += "Tidak ada data untuk ditampilkan :p";
                    temp += "</td>";
                    temp += "</tr>";
                }
                $("#alergy_body_table").html(temp);
            }
        );
        return false;
    }
}
function generik_list_change() {
    var nilai = $("#generik_list_alergi").val();
    console.log(
        "disabled = " +
            $("#myModal").find(".submit_button").hasClass("disabled")
    );
    console.log("not null = " + !!nilai);
    if (!!nilai && $("#myModal").find(".submit_button").hasClass("disabled")) {
        $("#myModal").find(".submit_button").removeClass("disabled");
    } else if (
        !nilai &&
        !$("#myModal").find(".submit_button").hasClass("disabled")
    ) {
        $("#myModal").find(".submit_button").addClass("disabled");
    }
}
