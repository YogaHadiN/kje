$("#tanggal_lahir")
    .datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: "dd-mm-yyyy",
    })
    .on("changeDate", function (ev) {
        if ($(this).val() != "") {
            if (moment($(this).val(), "DD-MM-YYYY", true).isValid()) {
                console.log("true");
                validateDateOfBirth(this);
            } else {
                console.log("false");
                validasi1($(this), "Format Tanggal Salah, harusnya dd-mm-yyyy");
            }
        }
    });
$("#tanggal_lahir").keyup(function () {
    if ($(this).val().length > 9) {
        if (moment($(this).val(), "DD-MM-YYYY", true).isValid()) {
            validateDateOfBirth(this);
        } else {
            validasi1($(this), "Format Tanggal Salah, harusnya dd-mm-yyyy");
        }
    }
});
function checkIfDuplicate(data, nama) {
    var count = 0;
    for (var i = 0, len = data.length; i < len; i++) {
        if (nama.substring(0, 3) == data[i].nama.substring(0, 3)) {
            count++;
        }
    }

    if (count > 1) {
        return true;
    }
    return false;
}
function cekNomorBpjsSama(control) {
    console.log("cekNomorBpjsSama");
    var pasien_id = $("#pasien_id").val();
    var asuransi_id = $("#asuransi_id").val();
    var nomor_asuransi_bpjs = "";
    var ambil_nomor_dari_nomor_asuransi = false;

    if (
        asuransi_id == "32" &&
        $(control).val().length > 12 &&
        $("#nomor_asuransi_bpjs").val() == ""
    ) {
        ambil_nomor_dari_nomor_asuransi = true;
        nomor_asuransi_bpjs = $(control).val();
    } else if ($("#nomor_asuransi_bpjs").val() != "") {
        nomor_asuransi_bpjs = $("#nomor_asuransi_bpjs").val();
    }
    if (nomor_asuransi_bpjs != "") {
        $.get(
            base + "/pasiens/cek/nomor_bpjs/sama",
            {
                nomor_bpjs: nomor_asuransi_bpjs,
                pasien_id: pasien_id,
            },
            function (data, textStatus, jqXHR) {
                if (data["duplikasi"] == "1") {
                    if (ambil_nomor_dari_nomor_asuransi) {
                        validasi1(
                            $(control),
                            'Nomor BPJS yang sama sudah digunakan oleh <a href="' +
                                base +
                                "/pasiens/" +
                                data["pasien"]["id"] +
                                '/edit">' +
                                data["pasien"]["nama"] +
                                ". Klik disini untuk melihat</a> Mohon hindari membuat pasien ganda"
                        );
                    } else {
                        validasi1(
                            $("#nomor_asuransi_bpjs"),
                            'Nomor BPJS yang sama sudah digunakan oleh <a href="' +
                                base +
                                "/pasiens/" +
                                data["pasien"]["id"] +
                                '/edit">' +
                                data["pasien"]["nama"] +
                                ". Klik disini untuk melihat</a> Mohon hindari membuat pasien ganda"
                        );
                    }
                }
            }
        );
    }
}
function validateDateOfBirth(control) {
    $.get(
        base + "/pasiens/cek/tanggal_lahir/sama",
        { tanggal_lahir_cek: $(control).val() },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (var i = 0, len = data.length; i < len; i++) {
                var duplicate = checkIfDuplicate(data, data[i].nama);

                temp += "<tr";
                if (duplicate) {
                    temp += ' class="danger"';
                }
                temp += ">";
                temp += '<td class="nama">';
                temp += data[i].nama;
                temp += "</td>";
                temp += '<td class="alamat">';
                temp += data[i].alamat;
                temp += "</td>";
                temp += '<td class="no_telp">';
                temp += data[i].no_telp;
                temp += "</td>";
                temp += '<td class="detil_action">';
                temp +=
                    '<a class="btn btn-info btn-sm" href="' +
                    base +
                    "/pasiens/" +
                    data[i].id +
                    '/edit"><i class="fas fa-info"></i></button>';
                temp += "</td>";
                temp += "</tr>";
            }
            if (data.length > 0) {
                $("#row_ajax_container").fadeIn("slow");
            }
            $("#ajax_container").html(temp);
        }
    );
}
