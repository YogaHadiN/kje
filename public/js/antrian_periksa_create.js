uk("umur_kehamilan", "hpht");
var ID_POLI = $("#poli_id").val();
if (ID_POLI == "14") {
    if ($("#divUsg").hasClass("hide")) {
        $("#divUsg").removeClass("hide");
    }
    if (!$("#divUsg").hasClass("rq")) {
        $("#divUsg").addClass("rq");
    }

    $(".divAnc").each(function (index, el) {
        if ($(this).hasClass("hide")) {
            $(this).removeClass("hide");
        }
        if (!$("#hamil").hasClass("rq")) {
            $("#hamil").addClass("rq");
        }
        if (!$("#hpht").hasClass("rq")) {
            $("#hpht").addClass("rq");
        }
        if (!$("#g").hasClass("rq")) {
            $("#g").addClass("rq");
        }
        if (!$("#p").hasClass("rq")) {
            $("#p").addClass("rq");
        }
        if (!$("#a").hasClass("rq")) {
            $("#a").addClass("rq");
        }
    });
    $("#hamil").val("1");
} else if (ID_POLI == "1") {
    $(".divAnc").each(function (index, el) {
        if ($(this).hasClass("hide")) {
            $(this).removeClass("hide");
        }
        if (!$(this).hasClass("rq")) {
            $(this).addClass("rq");
        }
    });
    if (!$("#divUsg").hasClass("hide")) {
        $("#divUsg").addClass("hide");
    }
    if ($("#divUsg").hasClass("rq")) {
        $("#divUsg").removeClass("rq");
    }
    $("#hamil").val("1");
} else {
    $(".divAnc").each(function (index, el) {
        if (!$(this).hasClass("hide")) {
            $(this).addClass("hide");
        }
    });
    if (!$("#divUsg").hasClass("hide")) {
        $("#divUsg").addClass("hide");
    }
}
viewPengantar();
function verifikasiWajahChange(control) {
    var verifikasi = $(control).val();
    if (verifikasi == 2) {
        Swal.fire({
            title: "Perhatian",
            text: "Apabila gambar pasien tidak jelas, Upload ulang gambar pasien di edit pasien",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Arahkan ke Edit Pasien",
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(
                    base + "/antrianperiksas/update/foto_pasien",
                    {},
                    function (data, textStatus, jqXHR) {
                        window.location =
                            base +
                            "/pasiens/" +
                            $("#pasien_id").val() +
                            "/edit";
                    }
                );
            } else {
                $(control).val("");
                $(control).focus();
            }
        });
    } else if (verifikasi == 3) {
        Swal.fire({
            title: "Perhatian",
            text: "Apabila gambar pasien tidak sama dengan wajah pasien, maka pasien harus didaftarkan ulang karena salah identifikasi pasien",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Hapus antrian ini",
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(
                    base +
                        "/antrianperiksas/delete/antrian_poli/" +
                        $("#antrian_poli_id").val(),
                    {},
                    function (data, textStatus, jqXHR) {
                        window.location =
                            base + "/antrians/proses/" + $("#antrian_id").val();
                    }
                );
            } else {
                $(control).val("");
                $(control).focus();
            }
        });
    }
}
function dummySubmit(control) {
    if (validatePass2(control)) {
        $("#submit").click();
    }
}
$("#cekFoto").modal({ backdrop: "static", keyboard: false });

function fokusKeAnemnesa() {
    $("#cekFoto").modal("hide");
}
function rowEntry(control) {
    var pasien_id = $(control)
        .closest("tr")
        .find("td:eq(0)")
        .find("div")
        .html();
    var nama_pengantar = $(control)
        .closest("tr")
        .find("td:eq(1)")
        .find("div")
        .html();
    finalActionToEnterPengantar(pasien_id, nama_pengantar);
}
function getPengantarObject() {
    var pengantars = $("#pengantars").val();
    return JSON.parse(pengantars);
}
function stringifyPengantar(pengantars) {
    viewPengantar();
    pengantars = JSON.stringify(pengantars);
    $("#pengantars").val(pengantars);
    viewPengantar();
    $("#modalCariPengantar").modal("hide");
}
function hapusPengantar(control) {
    var k = $(control).closest("tr").find(".k").html();
    Swal.fire({
        title: "Are you sure?",
        text:
            "Anda akan menghapus " +
            $(control).closest("tr").find(".nama_pengantar").html(),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            var pengantars = getPengantarObject();
            pengantars.splice(k, 1);
            stringifyPengantar(pengantars);
        }
    });
}
function hubunganChange(control) {
    var k = $(control).closest("tr").find(".k").html();
    var pengantars = getPengantarObject();
    pengantars[k].hubungan_keluarga_id = $(control).val();
    stringifyPengantar(pengantars);
}
function tidakDobelPengantar(pengantars, pasien_id) {
    var dobel = false;
    for (let i = 0, len = pengantars.length; i < len; i++) {
        if (pasien_id == pengantars[i].pasien_id) {
            dobel = true;
            break;
        }
    }
    return !dobel;
}
function viewPengantar() {
    var pengantars = getPengantarObject();
    var hubungan_keluargas = $("#hubungan_keluargas").val();
    hubungan_keluargas = JSON.parse(hubungan_keluargas);
    var temp = "";
    for (let i = 0, len = pengantars.length; i < len; i++) {
        temp += "<tr>";
        temp += "<td class='k hide'>";
        temp += i;
        temp += "</td>";
        temp += "<td class='nama_pengantar'>";
        temp += pengantars[i].nama_pengantar;
        temp += "</td>";
        temp += "<td>";
        temp +=
            "<select class='form-control rq' onchange='hubunganChange(this);return false;'>";
        temp += '<option value="">- Pilih -</option>';
        for (let a = 0, len = hubungan_keluargas.length; a < len; a++) {
            temp += "<option";
            temp += " value='" + hubungan_keluargas[a].id + "'";
            console.log("pengantars[i]", i);
            if (
                pengantars[i].hubungan_keluarga_id == hubungan_keluargas[a].id
            ) {
                temp += " selected";
            }
            temp += ">";
            temp += hubungan_keluargas[a].hubungan_keluarga;
            temp += "</option>";
        }
        temp += "</select>";
        temp += "</td>";
        temp += "<td>";
        temp +=
            "<button type='button' class='btn btn-sm btn-danger' onclick='hapusPengantar(this); return false;'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button>";
        temp += "</td>";
        temp += "</tr>";
    }
    $("#pengantar_container").html(temp);
}
function masukkanPengantar(control) {
    var pasien_id = $(control).closest("tr").find(".id").html();
    var nama_pengantar = $(control)
        .closest("tr")
        .find(".nama_anggota_keluarga")
        .html();
    finalActionToEnterPengantar(pasien_id, nama_pengantar);
}

function finalActionToEnterPengantar(pasien_id, nama_pengantar) {
    var pengatars = getPengantarObject();
    Swal.fire({
        title: "Are you sure?",
        text:
            "Anda akan menambahkan " +
            nama_pengantar +
            " sebagai Pengantar Pasien BPJS",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Lanjutkan",
    }).then((result) => {
        $("#modalCariPengantar").modal("hide");

        if (result.isConfirmed && tidakDobelPengantar(pengatars, pasien_id)) {
            $.get(
                base + "/antrianperiksas/get/hubungan_keluarga_id",
                { pasien_id: pasien_id },
                function (data, textStatus, jqXHR) {
                    // data = JSON.parse(data);
                    pengatars.push({
                        pasien_id: pasien_id,
                        nama_pengantar: nama_pengantar,
                        hubungan_keluarga_id:
                            data["hubungan_keluarga_id"] != 4 &&
                            data["kepala_keluarga_id"] ==
                                $("#kepala_keluarga_id").val()
                                ? data["hubungan_keluarga_id"]
                                : null,
                    });
                    stringifyPengantar(pengatars);
                }
            );
        } else if (!tidakDobelPengantar(pengatars, pasien_id)) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: nama_pengantar + " sudah ada dalam daftar pengantar",
                footer: '<a href="">Why do I have this issue?</a>',
            });
        }
    });
}
$("#hamil").change(function (e) {
    if ($(this).val() == "1") {
        $(".divAnc").removeClass("hide").hide().fadeIn(500);
    } else if ($(this).val() == "0") {
        empty();
        $(".divAnc").fadeOut(500);
    }
});
function empty() {
    $(".gpa").val("");
    $(".inputObs").val("");
    $("#perujuk_id").val("");
}
function hphtChange(control) {
    console.log($(control).val());
}
