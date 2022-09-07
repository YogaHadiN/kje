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
    var pengatars = getPengantarObject();
    var nama_pengantar = $(control)
        .closest("tr")
        .find("td:eq(1)")
        .find("div")
        .html();
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
            pengatars.push({
                pasien_id: pasien_id,
                nama_pengantar: nama_pengantar,
                hubungan_keluarga_id: null,
            });
            stringifyPengantar(pengatars);
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
