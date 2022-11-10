var harus_cek_gds = false;
$("#G").keyup(function (e) {
    riwObsG();
});
uk("umur_kehamilan", "hpht");
$("#hamil").change(function (e) {
    if ($(this).val() == "1") {
        $(".divAnc").removeClass("hide").hide().fadeIn(500);
    } else if ($(this).val() == "0") {
        empty();
        $(".divAnc").fadeOut(500);
    }
});
$("#perujuk_submit").click(function (e) {
    var nama = $("#nama_perujuk").val();
    var alamat = $("#alamat_perujuk").val();
    var no_telp = $("#no_telp_perujuk").val();

    if (nama == "") {
        validasi("#nama_perujuk", "Harus Diisi!!");
    } else {
        var param = {
            nama: nama,
            alamat: alamat,
            no_telp: no_telp,
        };

        console.log(param);

        $.post(base + "/anc/perujx", param, function (data) {
            data = $.parseJSON(data);
            console.log(data);
            if (data.success == "1") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:
                        "Bidan " +
                        nama +
                        " berhasil dimasukkan ke dalam database",
                });
                var temp =
                    '<option value="' + data.id + '">' + nama + "</option>";
                $("#perujuk_id")
                    .append(temp)
                    .val(data.id)
                    .selectpicker("refresh");
                $("#buat_perujuk").modal("hide");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "gagal",
                });
            }
        });
    }
});

function rowEntry(control) {
    $("#rowStatusGDS").hide();
    harus_cek_gds = false;

    riwayat = [];
    var ID_PASIEN = $(control).closest("tr").find(".pasien_id").html();
    var ID_POLI = $(control).closest("tr").find(".poli_id").html();
    var ID_STAF = $(control).closest("tr").find(".staf_id").html();
    var ID_ASURANSI = $(control).closest("tr").find(".asuransi_id").html();
    var namaPasien = $(control).closest("tr").find(".nama_pasien").html();
    var tanggal = $(control).closest("tr").find(".tanggal").html();
    var jam = $(control).closest("tr").find(".jam").html();
    var ID_ANTRIAN_POLI = $(control).closest("tr").find(".id").html();
    var antrian = $(control).closest("tr").find(".antrian").html();
    var image = $(control).closest("tr").find(".image").html();
    var pengantar = $(control).closest("tr").find(".pengantar").html();
    var umur = $(control).closest("tr").find(".umur").html();
    var bukan_peserta = $(control).closest("tr").find(".bukan_peserta").html();
    var prolanis_dm = $(control).closest("tr").find(".prolanis_dm").html();
    var prolanis_ht = $(control).closest("tr").find(".prolanis_ht").html();
    var no_telp = $(control).closest("tr").find(".no_telp").html();
    umur = umur.trim();

    console.log("ID_PASIEN :" + ID_PASIEN);
    console.log("ID_POLI :" + ID_POLI);
    console.log("ID_STAF :" + ID_STAF);
    console.log("ID_ASURANSI :" + ID_ASURANSI);
    console.log("namaPasien :" + namaPasien);
    console.log("tanggal :" + tanggal);
    console.log("jam :" + jam);
    console.log("ID_ANTRIAN_POLI :" + ID_ANTRIAN_POLI);
    console.log("antrian :" + antrian);
    console.log("image :" + image);
    console.log("pengantar :" + pengantar);
    console.log("umur :" + umur);
    console.log("bukan_peserta :" + bukan_peserta);
    console.log("prolanis_dm :" + prolanis_dm);
    console.log("prolanis_ht :" + prolanis_ht);
    console.log("no_telp :" + no_telp);

    $("#bukan_peserta").val(bukan_peserta);

    if (prolanis_dm == "1" || prolanis_ht == "1") {
        $("#alert_prolanis").modal("show");
        $("#no_telp_pasien").html(no_telp);
        $("#redirect_update_pasien").prop(
            "href",
            base + "/pasiens" + "/" + ID_PASIEN + "/edit"
        );
    }

    if (prolanis_dm == "1") {
        $.get(
            base + "/pasiens/ajax/status_cel_gds_bulan_ini",
            {
                pasien_id: ID_PASIEN,
            },
            function (data, textStatus, jqXHR) {
                data = $.trim(data);
                if (!data < 1) {
                    harus_cek_gds = true;
                    $("#rowStatusGDS").show();
                }
            }
        );
    } else {
        console.log("ini satu");
    }

    if (ID_ASURANSI == $("#asuransi_id_bpjs").val()) {
        $("#pastikan").show();
        cekBPJSkontrol(ID_PASIEN, ID_ASURANSI);
        $("#lblKecelakaanKerja").html(
            "Kecelakaan Kerja / Kecelakaan Lalu Lintas"
        );
        $("#divBukanPeserta").removeClass("hide").hide().fadeIn(500);
        $("#divPembayaran").removeAttr("class");
        $("#divPembayaran").addClass("col-lg-6 col-md-6");
    } else {
        $("#cekBPJSkontrol").hide();
        $("#pastikan").hide();
        $("#lblKecelakaanKerja").html("Kecelakaan Kerja");
        $("#divBukanPeserta").fadeOut(500);
        $("#divPembayaran").removeAttr("class");
        $("#divPembayaran").addClass("col-lg-12 col-md-12");
    }

    $("#usia").html(umur);
    $("#namaPasien1").val(namaPasien);
    $("#jamDatang1").html(jam);
    $("#jamDatang").val(jam);
    $("#pembayaran1 ").val(ID_ASURANSI).selectpicker("refresh");
    $("#ddlDokter").val(ID_STAF);
    $("#poli1").val(ID_POLI);
    $("#ID_PASIEN").val(ID_PASIEN);
    $("#tanggal").val(tanggal);
    $("#ID_ANTRIAN_POLI").val(ID_ANTRIAN_POLI);
    $("#antrian").val(antrian);
    $("#formfield").val(image);
    $("#pengantar").val(pengantar);
    $("#photo").attr("src", base + "/" + image);

    empty();

    if (ID_POLI == "usg") {
        if ($("#divUsg").hasClass("hide")) {
            $("#divUsg").removeClass("hide");
        }
        $(".divAnc").each(function (index, el) {
            if ($(this).hasClass("hide")) {
                $(this).removeClass("hide");
            }
        });
        $("#hamil").val("1");
    } else if (ID_POLI == "anc") {
        $(".divAnc").each(function (index, el) {
            if ($(this).hasClass("hide")) {
                $(this).removeClass("hide");
            }
        });
        if (!$("#divUsg").hasClass("hide")) {
            $("#divUsg").addClass("hide");
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
        $("#hamil").val("");
    }
}

function testSubmit(control) {
    if (!validatePass2(control)) {
    } else if (harus_cek_gds && $("#gds").val() == "") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "GDS harus Diisi!!",
        });
        validasi($("#gds"), "Harus Diisi!!");
    } else if ($("#usg").val() == "1") {
        $("#ok").click();
    } else {
        $("#LinkButton1").click();
    }
}

function gdsKeyUp(control) {
    var nilai = parseInt($(control).val());
    if (nilai > 10 && nilai < 80) {
        Swal.fire({
            icon: "warning",
            title: "Gula darah sewaktu antara 0 - 79, Ulangi GDS",
            text: "Pasien puasa terlalu lama, Minta pasien untuk makan dulu lalu diperiksakan gula darah nya lagi, pemeriksaan yang saat ini pasien juga harus tanda tangan jaga2 pasien tidak kembali lagi hari itu",
        });
    }
}

function alas(control) {
    var id = $(control).closest("tr").find(".id").html();
    var pasien_id = $(control).closest("tr").find(".pasien_id").html();
    var nama_pasien = addslashes(
        $(control).closest("tr").find(".nama_pasien").html()
    );

    $("#modal-alasan .id").val(id);
    $("#modal-alasan .pasien_id").val(pasien_id);
    $("#modal-alasan").modal("show");

    var onclick =
        "modalAlasan(this" +
        ", '" +
        pasien_id +
        "', '" +
        nama_pasien +
        "'); return false;";
    $("#modal-alasan .dummySubmit").attr("onclick", onclick);
}

function hapusSajalah() {
    var id = $("#alasan_id").val();
    var submit_id = $("#submit_id").val();
    console.log("id = " + id);
    $("#" + id).val($("#alasan_textarea").val());
    $("#" + submit_id).click();
}

function testSubmit2() {
    $("#LinkButton1").click();
}

function getOption() {
    $.post(base + "/perujuk", {}, function (data) {
        data = $.parseJSON(data);
        var temp = '<option value="" selected>-Pilih Perujuk-</option>';
        for (var i = 0; i < data.length; i++) {
            temp +=
                '<option value="' +
                data[i].id +
                '">' +
                data[i].nama +
                "</option>";
        }
        $("#perujuk_id").html(temp);
        $("#perujuk_id").selectpicker("refresh");
    });
}

function riwObsG() {
    if ($("#G").val() != "" && $("#G").val() < 10) {
        var pasien_id = $("#ID_PASIEN").val();
        var G = $("#G").val();
        $.post(
            base + "/anc/registerhamil",
            { G: G, pasien_id: pasien_id },
            function (data) {
                if (data != "") {
                    $("#hpht").val(data.hpht).attr("readonly", "readonly");
                    $("#umur_kehamilan")
                        .val(data.uk)
                        .attr("readonly", "readonly");
                    $("#P").val(data.p).attr("readonly", "readonly");
                    $("#A").val(data.a).attr("readonly", "readonly");
                }
            }
        );
    } else {
        $(".gpa2").val("").removeAttr("readonly");
        $(".inputObs").val("").removeAttr("readonly");
    }
}

function empty() {
    $(".gpa").val("");
    $(".inputObs").val("");
    $("#perujuk_id").val("");
}

function ubahKKKLL() {
    $("#kecelakaanKerja").val("1");
    $("#dummySubmitButton").click();
}
function closeModal() {
    $("#alert_prolanis").modal("hide");
}
function konfirmasiAsuransi(control) {
    var image = $(control).closest("tr").find(".image").html();
    var ktp_image = $(control).closest("tr").find(".ktp_image").html();
    var bpjs_image = $(control).closest("tr").find(".bpjs_image").html();
    var nama = $(control).closest("tr").find(".nama").html();
    var alamat = $(control).closest("tr").find(".alamat").html();
    var tanggal_lahir = $(control).closest("tr").find(".tanggal_lahir").html();
    var id = $(control).closest("tr").find(".id").html();
    var nomor_asuransi = $(control)
        .closest("tr")
        .find(".nomor_asuransi")
        .html();
    var nama_asuransi = $(control).closest("tr").find(".nama_asuransi").html();

    console.log(image);
    console.log(ktp_image);
    console.log(bpjs_image);
    console.log(nama);
    console.log(alamat);
    console.log(tanggal_lahir);
    console.log(nama_asuransi);

    $("#konfirmasi_antrian_poli_id").val(id);
    $("#konfirmasi_nama").val(nama);
    $("#konfirmasi_alamat").val(alamat);
    $("#konfirmasi_tanggal_lahir").val(tanggal_lahir);
    $("#konfirmasi_pasien_image").attr("src", image);
    $("#konfirmasi_ktp_image").attr("src", ktp_image);
    $("#konfirmasi_bpjs_image").attr("src", bpjs_image);
    $("#konfirmasi_nomor_asuransi").val(nomor_asuransi);
    $("#konfirmasiAsuransi .nama_asuransi").html(nama_asuransi);
    imgError();
}
