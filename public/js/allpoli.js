var addSatu = false;
var id_formula_sirup_add = "";
var gen_presc_index = 0;
var gen_presc_json = "";
var total_afi_count = 0;
var temp_sop_terapi = [];
var length_sop_terapi = "";
var i_sop_terapi = 0;

var asuransi_id = $("#asuransi_id").val();
var tipe_asuransi_id = getTipeAsuransiId(asuransi_id);
var plafon_bpjs_ini = 0;

var plafon_bpjs_ini =
    tipe_asuransi_id == 5
        ? parseInt($("#plafon_obat_bpjs_by_staf").val()) +
          $("#plafon_bpjs_tiap_pasien_baru").val() //7000
        : parseInt($("#plafon_obat_bpjs_by_staf").val());

var channel_name = "my-channel";
var event_name = "form-submitted";

Pusher.logToConsole = true;

var pusher = new Pusher(pusher_app_key, {
    cluster: pusher_cluster,
    forceTLS: true,
});

var channel = pusher.subscribe(channel_name);
channel.bind(event_name, function (data) {
    console.log("panggil_refresh_gambar");
    if (
        typeof data.antrian_periksa_id !== "undefined" &&
        data.antrian_periksa_id == $("#antrian_periksa_id").val()
    ) {
        $.get(
            base + "/periksas/refresh/gambar",
            { antrian_periksa_id: $("#antrian_periksa_id").val() },
            function (data, textStatus, jqXHR) {
                console.log("masuk refresh gambar");
                refreshGambar(data);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Berhasil menyimpan gambar",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        );
    }
});

$("#LinkButton2").on("click", function () {
    validasiKeterangan();
});

$("#myModal").on("show.bs.modal", function () {
    $("#generik_list_alergi").val("");
    $("#generik_list_alergi").selectpicker("refresh");
    generik_list_change();
});

if ($("#terapi").val() == "" || $("#terapi").val() == "[]") {
    var data = [];
    updatePlafon(0);
} else {
    console.log("ada data");
    var data = JSON.parse($("#terapi").val());
    viewResep(resepJson($("#terapi").val())[1]);
}
function getDataTindakan() {
    if ($("#tindakan").val() == "" || $("#tindakan").val() == "[]") {
        var dataTindakan = [];
    } else {
        var dataTindakan = JSON.parse($("#tindakan").val());
        viewTindakan(dataTindakan);
    }
    return dataTindakan;
}
var dataTindakan = getDataTindakan();
console.log(50);
console.log(dataTindakan);
console.log(51);

$("#dummy_submit_perujuk_baru").click(function () {
    var nama_perujuk = $("#nama_perujuk").val();
    var alamat_perujuk = $("#alamat_perujuk").val();
    var no_telp_perujuk = $("#no_telp_perujuk").val();

    if (nama_perujuk == "" || alamat_perujuk == "" || no_telp_perujuk == "") {
        if (nama_perujuk == "") {
            validasi("#nama_perujuk", "harus diisi!!");
        }
        if (alamat_perujuk == "") {
            validasi("#alamat_perujuk", "harus diisi!!");
        }
        if (no_telp_perujuk == "") {
            validasi("#no_telp_perujuk", "harus diisi!!");
        }
    } else {
        $("#submit_perujuk_baru").click();
    }
});
$("#submit_perujuk_baru").click(function () {
    var nama_perujuk = $("#nama_perujuk").val();
    var alamat_perujuk = $("#alamat_perujuk").val();
    var no_telp_perujuk = $("#no_telp_perujuk").val();
    $.post(
        base + "/perujuks/ajax/create",
        {
            nama: nama_perujuk,
            alamat: alamat_perujuk,
            no_telp: no_telp_perujuk,
        },
        function (data) {
            if (data.result == "1") {
                $("#perujuk_id")
                    .html(data.options)
                    .val(data.value)
                    .selectpicker("refresh");
                Swal.fire(
                    "Good job!",
                    "perujuk baru bernama " +
                        nama_perujuk +
                        " telah berhasil ditambahkan",
                    "success"
                );
                $("#modal_buat_perujuk_baru").modal("hide");
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "maaf !! perujuk telah gagal ditambahkan",
                });
                $("#modal_buat_perujuk_baru").modal("hide");
            }
        }
    );
});

jQuery(document).ready(function ($) {
    refresh();

    var notif = $("#notified").val();
    var tipe_asuransi_id = $("#asuransi_id option:selected").attr(
        "data-tipe-asuransi"
    );

    if (notif == "0" && tipe_asuransi_id == "5") {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Harap baca dengan Jelas aturan mengenai asuransi ini, ada satu / beberapa hal yang sudah ditambahkan. Terima kasih",
        });
    }

    $("#modal_buat_perujuk_baru").on("shown.bs.modal", function () {
        $("#nama_perujuk").focus();
    });
    $("#modal_buat_perujuk_baru").on("hidden.bs.modal", function () {
        $("#perujuk_id").closest("div").find(".btn-white").focus();
    });
    bahanHabisPakai();
    if ($("#resepluar").val() != "") {
        $("#panel-resepluar").show();
    }
    $("#cekFoto").modal({ backdrop: "static", keyboard: false });

    uk_exec("uk", "hpht");
    if ($("#kesimpulan").val() == "") {
        hasil();
    }
    riwObsG();
    $(".hasil").on("keyup change", function (e) {
        hasil();
    });

    $("#G").keyup(function (e) {
        riwObsG();
    });

    view();
    uk("umur_kehamilan", "HPHT");
    uk("uk", "hpht");

    $("#tab-status").on("shown.bs.tab", function (e) {
        $("#anamnesa").focus();
    });

    $("#usg_presentasi").blur(function (e) {
        if ($(this).val().indexOf("kepala") > -1) {
            $(".presentasi").val("2");
        } else if ($(this).val().indexOf("lintang") > -1) {
            $(".presentasi").val("3");
        } else if ($(this).val().indexOf("bokong") > -1) {
            $(".presentasi").val("4");
        }
    });

    $("#usg_djj").blur(function (e) {
        $("#djj").val($(this).val());
    });

    $("#tab-usg").on("shown.bs.tab", function (e) {
        $("#usg_presentasi").focus();
    });

    $("#tab-resep").on("shown.bs.tab", function (e) {
        namaObatFocus();
        var anamnesa = $("#anamnesa").val();
        var pf = $("#pemeriksaan_fisik").val();

        if (anamnesa != "" || pf != "") {
            var temp = '<div class="alert alert-warning">';
            temp += anamnesa + " | " + pf;
            temp += "</div>";
        }
        $("#resume").html(temp);
    });

    $("#keterangan_diagnosa").keydown(function (e) {
        var key = e.keyCode || e.which;

        if (key == 9) {
            $("#tab-resep").tab("show");
            return false;
        }
    });

    $("#modalTindakan").on("shown.bs.modal", function () {
        $("#selectTindakan").closest("td").find(".btn-white").focus();
    });

    $("#btn_auto").click(function (e) {
        if ($("#bb_input").val() == "") {
            var bb_input = "55";
        } else {
            var bb_input = $("#bb_input").val();
        }
        $("#bb_aktif").val(bb_input);

        var bb = $("#bb_aktif").val();
        $("#berat_badan").val(bb);

        $.get(
            base + "/DdlMerek/alloption2",
            {
                bb: bb,
                asuransi_id: $("#asuransi_id").val(),
            },
            function (data) {
                data = $.parseJSON(data);
                var berat_badan = data.berat_badan;
                data = data.temp;
                data = JSON.stringify(data);
                customOption2a(data, berat_badan);
            }
        );
    });

    $("#btn_auto_off").click(function (e) {
        optionSemua(getIdMerek());
    });

    $("#inputSigna").keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key != 13 || key != 38 || key != 40 || key != 9) {
            $.post(
                base + "/poli/ajax/selectsigna",
                { signa: $(this).val(), _token: $("#token").val() },
                function (data) {
                    data = JSON.parse(data);
                    var temp = "";
                    for (var i = data.length - 1; i >= 0; i--) {
                        temp += "<tr>";
                        temp += "<td>" + data[i].id + "</td>";
                        temp += "<td>" + data[i].signa + "</td>";
                        temp +=
                            '<td><button type="button" class="btn btn-success btn-xs" value="' +
                            data[i].id +
                            '" onclick="pilihSigna(this)">pilih</button></td>';
                        temp += "</tr>";
                    }
                    if (data.length == 0) {
                        temp =
                            '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>';
                    }
                    $("#tblSigna tbody").html(temp);
                }
            );
        }
    });
    $("#inputAturanMinum").keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key != 13 || key != 38 || key != 40 || key != 9) {
            $.post(
                base + "/poli/ajax/selectatur",
                { aturan: $(this).val() },
                function (data) {
                    data = JSON.parse(data);
                    var temp = "";
                    for (var i = data.length - 1; i >= 0; i--) {
                        temp += "<tr>";
                        temp += "<td>" + data[i].id + "</td>";
                        temp += "<td>" + data[i].aturan_minum + "</td>";
                        temp +=
                            '<td><button type="button" class="btn btn-success  btn-xs" value="' +
                            data[i].id +
                            '" onclick="pilihAturanMinum(this)">pilih</button></td>';
                        temp += "</tr>";
                    }

                    if (data.length == 0) {
                        temp =
                            '<tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>';
                    }
                    $("#tblAturanMinum tbody").html(temp);
                }
            );
        }
    });
    // untuk mencari ICD 10 diagnosa
    $(".search").keyup(function (e) {
        var key = e.keyCode || e.which;
        if (key != 38 && key != 40 && key != 13) {
            table_ICD();
        }
    });
    //keypress pencarian modal diagnosa pertama
    $(".search").on("keypress", function (e) {
        var rowI = $("table#GridView4 tbody tr")
            .filter(function () {
                var match = "rgb(51, 122, 183)";
                return $(this).css("background-color") == match;
            })
            .index();
        var key = e.keyCode || e.which;
        if (key == 13 && rowI != -1) {
            confirmICD();
        } else if (key == 40 && rowI == -1) {
            $("table#GridView4 tbody tr:first-child").toggleClass(
                "rowHighlight"
            );
        } else if (key == 40 && rowI != -1 && rowI != 9) {
            var rowI = $("table#GridView4 tbody tr")
                .filter(function () {
                    var match = "rgb(51, 122, 183)";
                    return $(this).css("background-color") == match;
                })
                .index();
            var rowBefore = parseInt(rowI) + 1;
            var rowAfter = parseInt(rowI) + 2;

            $(
                "table#GridView4 tbody tr:nth-child(" + rowBefore + ")"
            ).toggleClass("rowHighlight");
            $(
                "table#GridView4 tbody tr:nth-child(" + rowAfter + ")"
            ).toggleClass("rowHighlight");
        } else if (key == 38 && rowI != -1 && rowI != 0) {
            var rowI = $("table#GridView4 tbody tr")
                .filter(function () {
                    var match = "rgb(51, 122, 183)";
                    return $(this).css("background-color") == match;
                })
                .index();
            var rowBefore = parseInt(rowI) + 1;
            var rowAfter = rowI;
            $(
                "table#GridView4 tbody tr:nth-child(" + rowBefore + ")"
            ).toggleClass("rowHighlight");
            $(
                "table#GridView4 tbody tr:nth-child(" + rowAfter + ")"
            ).toggleClass("rowHighlight");
        }
    });
    //keypress pencarian modal diagnosa kedua untuk mencari / menginput Diagnosa baru
    $("#tambahDiagnosa").on("keypress", function (e) {
        var rowI = $("table#GridView2 tbody tr")
            .filter(function () {
                var match = "rgb(51, 122, 183)";
                return $(this).css("background-color") == match;
            })
            .index();

        var $ini = $(this);
        var last = parseInt($("table#GridView2 tbody tr:last").index());

        var key = e.keyCode || e.which;

        if (key == 13 && rowI == -1 && $ini.val() != "") {
            insertDiagnosa();
        } else if (key == 13 && rowI == -1 && $ini.val() == "") {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Untuk masukkan diagnosa input harus diisi",
            });
            $ini.focus();
            return false;
        } else if (key == 13 && rowI != -1) {
            confirmDiagnosa();
        } else if (key == 40 && rowI == -1) {
            $("table#GridView2 tbody tr:first-child").toggleClass(
                "rowHighlight"
            );
            $("#tambahDiagnosa").val("");
        } else if (key == 40 && rowI != last) {
            var rowBefore = parseInt(rowI) + 1;
            var rowAfter = parseInt(rowI) + 2;

            $(
                "table#GridView2 tbody tr:nth-child(" + rowBefore + ")"
            ).toggleClass("rowHighlight");
            $(
                "table#GridView2 tbody tr:nth-child(" + rowAfter + ")"
            ).toggleClass("rowHighlight");
            $("#tambahDiagnosa").val("");
        } else if (key == 40 && rowI == last) {
            return false;
        } else if (key == 38 && rowI != -1 && rowI != 0) {
            var rowI = $("table#GridView2 tbody tr")
                .filter(function () {
                    var match = "rgb(51, 122, 183)";
                    return $(this).css("background-color") == match;
                })
                .index();

            var rowBefore = parseInt(rowI) + 1;
            var rowAfter = rowI;

            $(
                "table#GridView2 tbody tr:nth-child(" + rowBefore + ")"
            ).toggleClass("rowHighlight");
            $(
                "table#GridView2 tbody tr:nth-child(" + rowAfter + ")"
            ).toggleClass("rowHighlight");
            $("#tambahDiagnosa").val("");
        } else if (key == 38 && rowI == 0) {
            return false;
        } else {
            var rowI = $("table#GridView2 tbody tr")
                .filter(function () {
                    var match = "rgb(51, 122, 183)";
                    return $(this).css("background-color") == match;
                })
                .index();

            var rowHighlight = parseInt(rowI) + 1;
            $(
                "table#GridView2 tbody tr:nth-child(" + rowHighlight + ")"
            ).toggleClass("rowHighlight");
        }
    });
    // Validasi jika anamnesa dan diagnosa belum diisi, maka gagal menginput

    //ketika exampleModal ditutup mereset example Modal = memilih ICD
    $("#exampleModal").on("hidden.bs.modal", function () {
        $("#byICD").val("");
        $("#byDiagnosa").val("").focus();
        table_ICD();
    });
    //ketika di klik, maka tabel di exampleModal = pencarian ICD akan menyala (highlight)
    $(document).on("click", "table#GridView4 tbody tr", function (e) {
        $(".rowHighlight").toggleClass("rowHighlight");
        $(this).toggleClass("rowHighlight");
        $("#byDiagnosa").focus();
    });
    //ketika di klik, maka tabel di pencarian diagnosa akan menyala (highlight)
    $(document).on("click", "table#GridView2 tbody tr", function (e) {
        $(".rowHighlight").toggleClass("rowHighlight");
        $(this).toggleClass("rowHighlight");
        $("#tambahDiagnosa").focus();
    });

    //ketika di klik untuk konfirmasi memilih ICD, maka ICD telah dipilih, tapi kalau belum dipilih, munculkan alert
    $(document).on("click", "#confirmICD", function (e) {
        var rowI = $("table#GridView4 tbody tr")
            .filter(function () {
                var match = "rgb(51, 122, 183)";
                return $(this).css("background-color") == match;
            })
            .index();
        if (rowI != -1) {
            confirmICD();
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "pilih dulu ICD nya",
            });
        }
    });

    //ketika memunculkan modal diagnosa yang kedua, kosongkan dulu isinya
    $("#exampleModal1").on("show.bs.modal", function () {
        $("input#tambahDiagnosa").val("").keyup().focus();
    });

    $("#inputTindakanSubmit").keypress(function (e) {
        var key = e.keyCode || e.which;
        if (key == 9) {
            $("#inputTindakanSubmit").click();
            return false;
        }
    });
    // valueTextArea();
    $("#modalTindakan").on("hidden.bs.modal", function () {
        console.log("====================");
        console.log("hidden");
        console.log("====================");
        bahanHabisPakai();
    });

    $("#modalSigna").on("hidden.bs.modal", function (e) {
        $("#ddlsigna").closest("div").find(".btn-white").focus();
    });

    $("#modalAturanMinum").on("hidden.bs.modal", function (e) {
        $("#ddlAturanMinum").closest("div").find(".btn-white").focus();
    });

    //perintah untuk memberikan perintah klik bila tombol Tab ditekan dan focus ada di tombol
    $("a#inputResep").keydown(function (e) {
        var $ini = $(this);
        var key = e.keyCode || e.which;

        if (key == 9 || key == 13) {
            insertTerapi();
            return false;
        }
    });

    //perintah yang diberikan bila Select tipe resep diganti opsi nya
    $("#tipeResep").change(function () {
        var tipe = $(this).val();
        var id = getIdMerek();

        // bila dirubah ke tipe 1 adalah puyer
        if (tipe == "1") {
            //hilangkan signa dan aturan minum obat, isian jumlah tetap dipertahankan
            //signa -1 adalah puyer
            hideTipeResepPuyer(id);

            // bila dirubah ke tipe 2 adalah add sirup
        } else if (tipe == "2") {
            hideTipeResepSirup(id);
            // bila dirubah ke tipe 0 adalah standar resep dewasa
        } else if (tipe == "0") {
            // direset pilihan signa, aturanminum, dan jummlah
            $("#ddlsigna")
                .val("")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeIn(500);
            $("#ddlAturanMinum")
                .val("")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeIn(500);
            $("#txtjumlah").val("").selectpicker("refresh").fadeIn(500);
            //jika tipe standar, maka pilihan nama obat dikembalikan lagi, semua resep tersedia
            optionSemua(id);
        }
    });
    //perintah yang diberikan jika pilihan obat berubah
    $("#ddlNamaObat").change(function () {
        if ($(this).val != "") {
            var isi = true;
        } else {
            var isi = false;
        }

        var pasien_id = $("#pasien_id").val();
        $.get(
            base + "/poli/ajax/alergi/prevent",
            {
                merek_id: $(this).val(),
                pasien_id: pasien_id,
            },
            function (data, textStatus, jqXHR) {
                if ($.trim(data) > 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "obat tidak bisa dipilih karena komposisi dari obat tersebut membuat pasien alergi",
                    });
                    $("#ddlNamaObat").val("").selectpicker("refresh");
                    return false;
                }
            }
        );
        //
        //i adalah ID_MEREK yang terpilih dari pilihan obat
        var dataObat = JSON.parse($(this).val());
        var i = dataObat.merek_id;

        var sediaan = getSediaan();
        var merek = getMerek();
        var formula_id = getIdFormula();
        var tidakDipuyer = getTidakDipuyer();
        var tipeResep = $("#tipeResep").val();

        if (sediaan == "syrup" && tipeResep == 2) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                    "obat " +
                    merek +
                    ", tidak boleh dicampur dengan obat lain karena bukan dry syrup seperti \nAmoxilin Syr \nThiamphenicol syr \n Cefadroksil syr \n atau cefixim syr \nYang bisa dicampur dengan obat lain",
            });
            $("#ddlNamaObat").val("").selectpicker("refresh");
            namaObatFocus();
            return false;
        }

        if (tidakDipuyer == "1" && (tipeResep == 1 || tipeResep == 2)) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                    "obat " +
                    merek +
                    ", tidak boleh dipuyer ataupun dicampur ke dalam sirup",
            });
            $("#ddlNamaObat").val("").selectpicker("refresh");
            namaObatFocus();
            return false;
        }

        // tipe resep 1 = puyer, ID_MEREK -1 DAN -3 ADALAH kertas puyer biasa dan sablon
        if ($("#tipeResep").val() == "1" && (i == "-1" || i == "-3")) {
            //jika kertas puyer (-3/-1) terpilih pada tipe resep puyer (1), maka,
            //tampilkan kembali semua item
            //dan tipe resep dikembalikan lagi menjadi tipe resep standar (0)
            $("#ddlsigna")
                .val("")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeIn(500);
            $("#ddlAturanMinum")
                .val("1")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeIn(500);
            $("#tipeResep").val("0").selectpicker("refresh");
            //kembalikan lagi opsi pilihan obat sehingga semua obat bisa diakses
            optionSemua(i);
            // jika item selesaikan puyer ada dalam html. maka kembalikan semua ke standar
            if ($("#selesaikanPuyer").html()) {
                selesaiPuyer($("#selesaikanPuyer"));
            }
        } else if ($("#tipeResep").val() == "2" && i == "-2") {
            $("#txtjumlah")
                .val("1")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeOut(500);
            $("#ddlsigna")
                .val("")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeIn(500);
            $("#ddlAturanMinum")
                .val("1")
                .selectpicker("refresh")
                .closest(".input-group")
                .fadeIn(500);
            $("#tipeResep").val("0").selectpicker("refresh");
            optionSemua(i);
            if ($("#selesaikanAdd").html()) {
                selesaiAdd($("#selesaikanAdd"));
            }
        }
        //Kode untuk Automator
        var aturan_minum_id = getAturanMinumId();

        $("#ddlAturanMinum").val(aturan_minum_id).selectpicker("refresh");

        if ($("#bb_aktif").val() != "" && $("#ddlNamaObat").val() != "") {
            var dose = $("#ddlNamaObat option:selected").attr("data-dose");
            dose = $.parseJSON(dose);
            var signa_id = dose.signa_id;
            var jumlah = dose.jumlah;

            $("#txtjumlah").val(jumlah);
            $("#ddlsigna").val(signa_id).selectpicker("refresh");
        }
        // Munculkan peringatan obat
        if ($(this).val() != "") {
            var peringatan = $("#ddlNamaObat option:selected").attr(
                "data-peringatan"
            );
            var ingat = "";

            if (peringatan != "null") {
                ingat = peringatan;

                var merek = $("#ddlNamaObat option:selected").text();

                var pesan =
                    '<div class="panel panel-danger" id="isi_pesan"><div class="panel-heading"><h1 class="panel-title">' +
                    merek +
                    '</h1></div><div class="panel-body">' +
                    ingat +
                    "</div></div>";

                $("#peringatan").html(pesan);

                $("#isi_pesan").hide().slideDown(500);
            } else {
                $("#isi_pesan").slideUp(500, function () {
                    $(this).remove();
                });
            }
        }
        //Munculkan peringatan kalau obat tidak ditanggung BPJS
        if (
            $("#asuransi_id option:selected").attr("data-tipe-asuransi") == "5"
        ) {
            if ($(this).val() != "") {
                //jika pilihan nama obat tidak kosong
                var tipe_formula_id = getTipeFormulaId();
                var tipe_resep = $("#tipeResep").val();
                var merek = $("#ddlNamaObat option:selected").text();
                var fornas = $("#ddlNamaObat option:selected").attr(
                    "data-fornas"
                );
                if (tipe_formula_id == 5 && tipe_resep == "1") {
                    //
                } else {
                    if (fornas == "0") {
                        $("#isi_pesan_fornas").remove();
                        var text =
                            '<div class="alert alert-danger" id="isi_pesan_fornas">' +
                            merek +
                            " <strong>tidak ditanggung BPJS</strong></div>";
                        $("#peringatan").prepend(text);
                        $("#isi_pesan_fornas").hide().fadeIn(500);
                    } else {
                        $("#isi_pesan_fornas").fadeOut(500, function () {
                            $(this).remove();
                        });
                    }
                }
            }
        }

        $.post(
            base + "/poli/ajax/ibusafe",
            {
                merek_id: $(this).val(),
                umur: $("#umur").html(),
                _token: $("#token").val(),
            },
            function (data) {
                /*optional stuff to do after success */
                data = $.trim(data);
                if (data == "1") {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ibuprofen syrup / tablet tidak boleh digunakan untuk anak dibawah umur 1 tahun, gunakan ibuprofen suppositoria dalam kondisi darurat!! Optimalkan pemberian paracetamol 15 mg/kgbb tiap 4 jam, disertai dengan ibuprofen supp bila kepepet !!",
                    });
                    $("#ddlNamaObat").val("").selectpicker("refresh");
                }
            }
        );

        if ($("#hamil").val() == "1") {
            $.post(
                base + "/poli/ajax/pregsafe",
                { merek_id: $(this).val() },
                function (data) {
                    data = $.trim(data);
                    if (data != "") {
                        data = $.parseJSON(data);
                        var temp =
                            '<h4 class="text-center">Peringatan keamanan</h4>';
                        temp += '<h4 class="text-center">dalam kehamilan</h4>';
                        temp +=
                            '<table class="table table-condensed table-bordered font-kecil">';
                        temp +=
                            '<thead><tr><th class="bg-red">Generik</th><th class="bg-red">Safety Index</th></tr></thead>';
                        temp += "<tbody>";
                        for (var i = 0; i < data.length; i++) {
                            temp += "<tr>";
                            temp +=
                                "<td>" +
                                data[i].generik +
                                " " +
                                data[i].bobot +
                                "</td>";
                            temp +=
                                "<td>" +
                                data[i].pregnancy_safety_index +
                                "</td>";
                            temp += "</tr>";
                        }
                        temp += "</tbody></table>";

                        $("#legendpop").attr({
                            title: $("#ddlNamaObat option:selected").text(),
                            "data-original-title": $(
                                "#ddlNamaObat option:selected"
                            ).text(),
                            "data-content": temp,
                        });

                        $("#legendpop").popover("show");
                    } else {
                        $("#legendpop").popover("hide");
                    }
                }
            );
        } else if ($(this).val() == "150805003") {
            $("#legendpop").attr({
                title: "Decafil tabet 150 mg",
                "data-original-title": "Decafil tabet 150 mg",
                "data-content":
                    "Jika pasien sudah biasa/sering sesak nafas, decafil diberikan 20 tablet agar pasien tidak perlu bolak-balik ke klinik, termasuk dan terutama pasien BPJS",
            });
            $("#legendpop").popover("show");
        } else if (
            formula_id == "150802046" &&
            $("#asuransi_id option:selected").attr("data-tipe-asuransi") == "5"
        ) {
            $("#legendpop").attr({
                title: "Levofloxacine tabet 500 mg",
                "data-original-title": "Levofloxacine tabet 500 mg",
                "data-content":
                    "Pada pasien BPJS dengan Typhoid fever, obat ini diberikan selama 6 hari, obat simtomatik lain diberikan selama 3 hari, diharapkan pasien tidak kontrol kalau keadaan membaik dan tinggal habiskan antibiotiknya saja",
            });
            $("#legendpop").popover("show");
        } else {
            $("#legendpop").popover("hide");
        }
    });

    $('[data-toggle="popover"]').popover();

    sesuaikanResep();

    $("#pemeriksaan_penunjang").keypress(function (e) {
        var key = e.keyCode || e.which;
        if (key != 9) {
            $("#modalTindakan").modal("show");
            $(this).blur();
            return false;
        }
    });
    setTimeout(function () {
        $("#anamnesa").focus();
    }, 500);

    $(".afi_count").keyup(function (e) {
        afiCount();
    });
}); //end document.ready

function afiCount() {
    $(".afi_count").each(function (index, el) {
        var count = $(this).val();
        console.log("count before = " + count);
        count = count.replace(",", "."); // sudah bisa mereplace karakter ','
        count = count.replace(" ", ""); // sudah bisa mereplace karakter spasi (' ')
        if (count == "") {
            count = 0;
        }
        total_afi_count += parseFloat(count);
    });

    $("#total_afi").val(total_afi_count + " cm");
    hasil();
    total_afi_count = 0;
}

function getDiagnosaByICD(ICD) {
    $.ajax({
        url: base + "/poli/ajax/diag",
        type: "GET",
        data: { icd10: ICD },
    })
        .done(function (messages) {
            messages = JSON.parse(messages);
            var temp = "";

            for (var i = 0; i < messages.length; i++) {
                temp += '<tr class="anchor2">';
                temp += "<td>" + messages[i].id + "</td>";
                temp += "<td>" + messages[i].diagnosa + "</td>";
                temp += "</tr>";
            }

            $("#ajax4").html(temp);
            $("#tambahDiagnosa").val("").focus();
        })
        .fail(function () {
            alert("Error!");
        });
}

function insertDiagnosa() {
    var ICD = $("#lblICD").html();
    var diagnosaUmum = $("#tambahDiagnosa").val();
    $.ajax({
        url: base + "/poli/ajax/indiag",
        type: "POST",
        data: { icd10: ICD, diagnosa: diagnosaUmum, _token: $("#token").val() },
    })
        .done(function (result) {
            result = $.trim(result);
            if (result == "0") {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: diagnosaUmum + " GAGAL diinput",
                });
            } else if (result == "01") {
                validasi("#tambahDiagnosa", "Sudah ada!!");
            } else {
                result = JSON.parse(result);

                Swal.fire({
                    icon: "success",
                    title: "Good Job!",
                    text: diagnosaUmum + " berhasil diinput",
                });
                getDiagnosaByICD(ICD);
                var opt =
                    '<option value="' +
                    result.id +
                    '">' +
                    result.diagnosa +
                    " - " +
                    result.diagnosaICD +
                    "</option>";
                $("#ddlDiagnosa").append(opt).selectpicker("refresh");
            }
        })
        .fail(function () {
            alert("Error!");
        });
}

function confirmICD() {
    var ICD = $("table#GridView4 tbody tr")
        .filter(function () {
            var match = "rgb(51, 122, 183)";
            return $(this).css("background-color") == match;
        })
        .find("td:first-child")
        .html();
    var Diag = $("table#GridView4 tbody tr")
        .filter(function () {
            var match = "rgb(51, 122, 183)";
            return $(this).css("background-color") == match;
        })
        .find("td:nth-child(2)")
        .html();
    $("#lblICD").html(ICD);
    $("#lblDiagnosaICD").html(Diag);
    getDiagnosaByICD(ICD);
    $("#showModal2").click();
    $("#hideModal1").click();
}

function confirmDiagnosa() {
    var idDiagnosa = $("table#GridView2 tbody tr")
        .filter(function () {
            var match = "rgb(51, 122, 183)";
            return $(this).css("background-color") == match;
        })
        .find("td:first-child")
        .html();
    $("#ddlDiagnosa").val(idDiagnosa).selectpicker("refresh");
    $("#diagnosa").val(idDiagnosa);
    $("#hideModal2").click();
    $("#keterangan_diagnosa").focus();
}

function table_ICD() {
    $.post(
        base + "/poli/ajax/pilih",
        {
            byICD: $("#byICD").val(),
            byDiagnosa: $("#byDiagnosa").val(),
            _token: $("#token").val(),
        },
        function (data) {
            var temp = "";
            for (var i = 0; i < data.length; i++) {
                temp += '<tr class="anchor2">';
                temp += "<td>" + data[i].id + "</td>";
                temp += "<td>" + data[i].diagnosaICD + "</td>";
                temp += "</tr>";
            }
            $("#temp").html(temp);
        }
    );
}

//----------------------================================================================
//----------------------================================================================
//----------------------================================================================
//----------------------================================================================
//----------------------================================================================
//----------------------================================================================

function insertTerapi() {
    var MER = $("#ddlNamaObat option:selected").text();
    var juml = $("#txtjumlah").val();
    var ID_SIG = $("#ddlsigna").val();
    var ID_ATU = $("#ddlAturanMinum").val();
    var pattern = /syrup/;
    var sirup = pattern.test(MER);
    var attr = $("#ddlNamaObat").attr("disabled");

    if (typeof attr !== typeof undefined && attr !== false) {
        $("#ddlNamaObat").removeAttr("disabled").selectpicker("refresh");
    }

    var attr = $("#tipeResep").attr("disabled");

    if (typeof attr !== typeof undefined && attr !== false) {
        $("#tipeResep").removeAttr("disabled").selectpicker("refresh");
    }

    if (
        $("#ddlNamaObat").val() == "" ||
        juml == "" ||
        ID_SIG == "" ||
        ID_ATU == ""
    ) {
        if ($("#ddlNamaObat").val() == "") {
            validasi("#ddlNamaObat", "Harus Diisi!");
        }
        if ($("#txtjumlah").val() == "") {
            validasi("#txtjumlah", "Harus Diisi!");
        }
        if ($("#ddlsigna").val() == "") {
            validasi2("#ddlsigna", "Harus Diisi!");
        }
        if ($("#ddlAturanMinum").val() == "") {
            validasi2("#ddlAturanMinum", "Harus Diisi!");
        }
    } else if (sirup && juml > 1) {
        var r = confirm(
            "Anda akan menginput SIRUP DALAM JUMLAH BANYAK, hal ini tidak lazim dan bisa merupakan suatu kesalahan. Lanjutkan?"
        );
        if (r) {
            insert();
        }
    } else if (juml > 20) {
        var r = confirm("Jumlah nya bisa jadi terlalu banyak. Lanjutkan?");
        if (r) {
            insert();
        }
    } else {
        var ID_FOR = getIdFormula();
        var Merek = "";

        var sama = false;
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                if (data[i].formula_id == ID_FOR) {
                    sama = true;
                    Merek = data[i].merek;
                    break;
                }
            }
        }
        if (!sama) {
            insert();
        } else {
            var r = confirm(
                "Formula yang sama sudah dimasukkan dengan Nama = " +
                    Merek +
                    ", Lanjutkan?"
            );
            if (r) {
                insert();
            }
        }
    }
    // bagian ini khusus dilakukan jika tipe_asuransi == 4 / flat
    //
}

function formSigna() {
    $.ajax({
        url: "ajaxSigna.php",
        type: "POST",
        data: { _token: $("#token").val() },
    })
        .done(function (result) {
            result = $.trim(result);
            $("#ajax6").html(result);
        })
        .fail(function () {
            console.log("error");
        })
        .complete(function () {
            $("#GridView4").dataTable({
                responsive: true,
            });
            $("#inputSigna").val("");
            $("#modalSigna input.input-sm").keypress(function (e) {
                var key = e.keyCode || e.which;
                if (key == 13) {
                    insertSigna();
                    console.log("enter");
                }
            });
        });
    return false;
}

//ajax5
$("#inputAturanMinum").focus();

var ID_SIGNA_BARU = "";
function insertSigna() {
    var signa = $("#inputSigna").val();
    if (signa != "") {
        $.ajax({
            url: base + "/poli/ajax/insigna",
            type: "POST",
            data: { signa: signa, _token: $("#token").val() },
        })
            .done(function (result) {
                result = JSON.parse(result);

                if (result.warning != "") {
                    validasi("#inputSigna", result.warning);
                } else {
                    var opt =
                        '<option value="' +
                        result.id +
                        '">' +
                        signa +
                        "</option>";
                    var MyArray = result.temp;
                    $("#ddlsigna")
                        .append(opt)
                        .val(MyArray.id)
                        .selectpicker("refresh");
                    var temp = "";
                    temp += "<tr>";
                    temp += "<td>" + MyArray.id + "</td>";
                    temp += "<td>" + MyArray.signa + "</td>";
                    temp +=
                        '<td><button class="btn btn-success btn-xs" value="' +
                        MyArray.id +
                        '" onclick="pilihSigna(this)">Pilih</button></td>';
                    temp += "</tr>";
                    $("#tblSigna tbody")
                        .html(temp)
                        .hide()
                        .fadeIn(300, function () {
                            $("#modalSigna").modal("hide");
                        });
                }
            })
            .fail(function () {
                console.log("error");
            });
        return false;
    } else {
        validasi("#inputSigna", "Input Tidak Boleh Kosong");
        $("#inputSigna").focus();
    }
}

//ajax5
var ID_ATURAN_MINUM_BARU = "";
function insertAturanMinum() {
    var aturan = $("#inputAturanMinum").val();
    if (aturan != "") {
        $.ajax({
            url: base + "/poli/ajax/inatur",
            type: "POST",
            data: {
                aturan: $("#inputAturanMinum").val(),
                _token: $("#token").val(),
            },
        })
            .done(function (result) {
                result = JSON.parse(result);

                if (result.warning != "") {
                    validasi("#inputAturanMinum", result.warning);
                } else {
                    var opt =
                        '<option value="' +
                        result.id +
                        '">' +
                        aturan +
                        "</option>";
                    var MyArray = result.temp;
                    $("#ddlAturanMinum")
                        .append(opt)
                        .val(MyArray.id)
                        .selectpicker("refresh");
                    var temp = "";
                    temp += "<tr>";
                    temp += "<td>" + MyArray.id + "</td>";
                    temp += "<td>" + MyArray.aturan_minum + "</td>";
                    temp +=
                        '<td><button class="btn btn-success btn-xs" value="' +
                        MyArray.id +
                        '" onclick="pilihAturanMinum(this)">Pilih</button></td>';
                    temp += "</tr>";

                    $("#tblAturanMinum tbody")
                        .html(temp)
                        .hide()
                        .fadeIn(300, function () {
                            $("#modalAturanMinum").modal("hide");
                        });
                }
            })
            .fail(function () {
                console.log("error");
            });
        return false;
    } else {
        Swal.fire("Oops!", "input tidak boleh kosong", "error");
        return false;
    }
}
//ajax5
function ddlSigna(sign) {
    $.ajax({
        url: "ddlSignaRuangPeriksa.php",
        type: "POST",
        data: { ID_SIGNA: sign, _token: $("#token").val() },
    })
        .done(function (result) {
            result = $.trim(result);
            $("#ddlsigna").html(result).selectpicker("refresh");
        })
        .fail(function () {
            console.log("error");
        });
    return false;
}

function selesaiPuyer(control) {
    var asuransi_id = $("#asuransi_id").val();
    $("#tipeResep").val("0").selectpicker("refresh");
    $(control).fadeOut("400", function () {
        $("#tipeResep")
            .closest("div")
            .find(".btn-white")
            .closest("div")
            .fadeIn("400");
    });

    var merek_id_kertas_puyer_sablon = $("#merek_id_kertas_puyer_sablon").val();
    $("#ddlNamaObat")
        .val(merek_id_kertas_puyer_sablon)
        .selectpicker("refresh")
        .closest("div")
        .fadeIn(400);

    console.log($("#ddlNamaObat").val(), "val");

    $("#ddlNamaObat, #tipeResep")
        .prop("disabled", true)
        .selectpicker("refresh");
    $("#ddlsigna, #ddlAturanMinum").val("0").selectpicker("refresh");
    $("#ddlsigna, #ddlAturanMinum").closest("div").fadeIn(400);
    $("#txtjumlah").focus();
    return false;
}

function selesaiAdd(control) {
    var asuransi_id = $("#asuransi_id").val();
    $("#tipeResep").val("0").selectpicker("refresh");
    $(control).fadeOut("400", function () {
        $("#tipeResep")
            .closest("div")
            .find(".btn-white")
            .closest("div")
            .fadeIn("400");
    });
    var merek_id_add_sirup = $("#merek_id_add_sirup").val();
    $("#ddlNamaObat")
        .val(merek_id_add_sirup)
        .selectpicker("refresh")
        .closest("div")
        .fadeIn(400);
    $("#ddlNamaObat, #tipeResep")
        .prop("disabled", true)
        .selectpicker("refresh");
    $("#ddlsigna, #ddlAturanMinum").val("0").selectpicker("refresh");
    $("#ddlsigna, #ddlAturanMinum").closest("div").fadeIn(400);
    if (addSatu) {
        $("#txtjumlah").val("1").hide();
    } else {
        $("#txtjumlah").val("0").hide();
    }
    $("#ddlsigna").closest("div").find(".btn-white").focus();
    return false;
}

function optionSyrup(ID_MEREK) {
    $.ajax({
        url: base + "/DdlMerek/optionsyrup",
        type: "GET",
        data: {
            ID_MEREK: ID_MEREK,
            asuransi_id: $("#asuransi_id").val(),
        },
    })
        .done(function (result) {
            customOption(result);
        })
        .fail(function () {
            console.log("error");
        })
        .complete(function () {
            $("#ddlNamaObat").selectpicker("refresh");
        });
}

function optionPuyer(ID_MEREK) {
    $.ajax({
        url: base + "/DdlMerek/optionpuyer",
        type: "GET",
        data: {
            ID_MEREK: ID_MEREK,
            asuransi_id: $("#asuransi_id").val(),
        },
    })
        .done(function (result) {
            customOption(result);
        })
        .fail(function () {
            console.log("error");
        })
        .complete(function () {
            $("#ddlNamaObat").selectpicker("refresh");
        });
}

function optionSemua(merek_id) {
    $.ajax({
        url: base + "/DdlMerek/alloption",
        type: "GET",
        data: { asuransi_id: $("#asuransi_id").val() },
    })
        .done(function (dataMerek) {
            customOption(dataMerek);
        })
        .fail(function () {
            console.log("error");
        });
}

function resetSignaAturanMinum() {
    $("#ddlsigna").val("").selectpicker("refresh");
    $("#ddlAturanMinum").val("").selectpicker("refresh");
    $("#txtjumlah").val("");
}
function resetAll() {
    resetSignaAturanMinum();
    $("select.kosong").val("").selectpicker("refresh");
    namaObatFocus();
    console.log("1");
    alert("reset all");
}
function pilihSigna(control) {
    var id = $(control).val();
    $("#ddlsigna").val(id).selectpicker("refresh");
    $("#hideModalSigna").click();
}
function pilihAturanMinum(control) {
    var id = $(control).val();
    $("#ddlAturanMinum").val(id).selectpicker("refresh");
    $("#hideModalAturanMinum").click();
}
function insert() {
    var ID_MER = getIdMerek();
    var ID_FOR = getIdFormula();
    var tipe_formula_id = getTipeFormulaId();
    var fornas = getFornas();
    var harga_jual = getHargaJual();
    var tipe_resep = $("#tipeResep").val();

    if (tipe_formula_id == 5 && tipe_resep == "1") {
        fornas = "1";
    }

    var MER = $("#ddlNamaObat option:selected").text();
    var juml = $("#txtjumlah").val();
    var ID_SIG = $("#ddlsigna").val();
    var ID_ATU = $("#ddlAturanMinum").val();

    $("#legendpop").popover("hide");

    data[data.length] = {
        jumlah: juml,
        merek_id: ID_MER,
        rak_id: getRakId(),
        harga_jual_ini: harga_jual,
        harga_beli_ini: getHargaBeli(),
        harga_beli_satuan: getHargaBeli(),
        formula_id: ID_FOR,
        merek_obat: MER,
        fornas: fornas,
        signa: $("#ddlsigna option:selected").text(),
        aturan_minum: $("#ddlAturanMinum option:selected").text(),
    };

    var string = JSON.stringify(data);
    $("#terapi").val(string);

    sesuaikanInputResep(ID_MER);
    var resep = resepJson(string);
    viewResep(resep[1]); // container untuk perscription generator
    namaObatFocus();
    $(".kosong").val("");
    $("select.kosong").selectpicker("refresh");
    if ($("#ddlsigna").val() > 0) {
        resetSignaAturanMinum();
        alert("kosongkan");
    }
}

function customOption(dataMerek) {
    var id = getIdMerek();

    dataMerek = JSON.parse(dataMerek);
    var temp = "";

    for (var i = 0; i < dataMerek.length; i++) {
        if (dataMerek[i].merek_id == id) {
            temp += '<option data-custom-value=\'{ "formula_id" : "';
            temp += dataMerek[i].formula_id;
            temp += '", "rak_id" : "';
            temp += dataMerek[i].rak_id;
            temp += '", "merek_id" : "';
            temp += dataMerek[i].merek_id;
            temp += '", "tipe_formula_id" : "';
            temp += dataMerek[i].tipe_formula_id;
            temp += '", "harga_beli" : "';
            temp += dataMerek[i].harga_beli;
            temp += '" , "aturan_minum_id" : "';
            temp += dataMerek[i].aturan_minum_id;
            temp += '" , "harga_jual" : "';
            temp += dataMerek[i].harga_jual;
            temp += '" , "sediaan" : "';
            temp += dataMerek[i].sediaan;
            temp += '" , "tidak_dipuyer" : "';
            temp += dataMerek[i].tidak_dipuyer;
            temp += '" }\' selected="selected" data-subtext=\'';
            for (var e = 0; e < dataMerek[i].komposisi.length; e++) {
                temp += "<br/>";
                temp += dataMerek[i].komposisi[e];
            }
            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";
            temp += dataMerek[i].peringatan;
            temp += "' data-fornas='";
            temp += dataMerek[i].fornas;
            temp += "' data-alternatif='";
            temp += dataMerek[i].alternatif;
            temp += "'>";
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    "<strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    " <strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += "</option>";
        } else {
            temp += '<option data-custom-value=\'{ "formula_id" : "';
            temp += dataMerek[i].formula_id;
            temp += '", "rak_id" : "';
            temp += dataMerek[i].rak_id;
            temp += '", "merek_id" : "';
            temp += dataMerek[i].merek_id;
            temp += '", "harga_beli" : "';
            temp += dataMerek[i].harga_beli;
            temp += '" , "aturan_minum_id" : "';
            temp += dataMerek[i].aturan_minum_id;
            temp += '" , "harga_jual" : "';
            temp += dataMerek[i].harga_jual;
            temp += '" , "sediaan" : "';
            temp += dataMerek[i].sediaan;
            temp += '" , "tidak_dipuyer" : "';
            temp += dataMerek[i].tidak_dipuyer;
            temp += "\" }' data-subtext='";

            for (var e = 0; e < dataMerek[i].komposisi.length; e++) {
                temp += "<br/>";
                temp += dataMerek[i].komposisi[e];
            }

            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";
            temp += dataMerek[i].peringatan;
            temp += "'  data-fornas='";
            temp += dataMerek[i].fornas;
            temp += "' data-alternatif='";
            temp += dataMerek[i].alternatif;
            temp += "'>";
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    " <strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += "</option>";
        }
    }

    $("#ddlNamaObat").html(temp).selectpicker("refresh");
    $("#bb_aktif").val("");
    $("#keterangan_auto_keterangan").hide();
    $(".auto").show(500);
    $("#btn_auto_off").hide(500);
    namaObatFocus();
}

function customOption2(dataMerek, berat_badan) {
    console.log("customOption2");

    var id = getIdMerek();

    dataMerek = JSON.parse(dataMerek);
    var temp = "";
    for (var i = 0; i < dataMerek.length; i++) {
        var doses = JSON.stringify(dataMerek[i].doses);

        if (dataMerek[i].merek_id == id) {
            temp += "<option data-dose='";
            temp += doses;
            temp += '\' data-custom-value=\'{ "formula_id" : "';
            temp += dataMerek[i].formula_id;
            temp += '", "rak_id" : "';
            temp += dataMerek[i].rak_id;
            temp += '", "merek_id" : "';
            temp += dataMerek[i].merek_id;
            temp += '", "harga_beli" : "';
            temp += dataMerek[i].harga_beli;
            temp += '" , "aturan_minum_id" : "';
            temp += dataMerek[i].aturan_minum_id;
            temp += '" , "harga_jual" : "';
            temp += dataMerek[i].harga_jual;
            temp += '" , "sediaan" : "';
            temp += dataMerek[i].sediaan;
            temp += '" , "tidak_dipuyer" : "';
            temp += dataMerek[i].tidak_dipuyer;
            temp += '" }\' selected="selected" data-subtext=\'';

            for (var e = 0; e < dataMerek[i].komposisi.length; e++) {
                if (e < 1) {
                    temp += dataMerek[i].komposisi[e];
                } else {
                    temp += "////<br/>";
                    temp += dataMerek[i].komposisi[e];
                }
            }

            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";
            temp += dataMerek[i].peringatan;
            temp += "' data-fornas='";
            temp += dataMerek[i].fornas;
            temp += "' data-alternatif='";
            temp += dataMerek[i].alternatif;
            temp += "'>";
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    " <strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += "</option>";
        } else {
            temp += "<option data-dose='";
            temp += doses;
            temp += '\' data-custom-value=\'{ "formula_id" : "';
            temp += dataMerek[i].formula_id;
            temp += '", "rak_id" : "';
            temp += dataMerek[i].rak_id;
            temp += '", "merek_id" : "';
            temp += dataMerek[i].merek_id;
            temp += '", "harga_beli" : "';
            temp += dataMerek[i].harga_beli;
            temp += '" , "aturan_minum_id" : "';
            temp += dataMerek[i].aturan_minum_id;
            temp += '" , "harga_jual" : "';
            temp += dataMerek[i].harga_jual;
            temp += '" , "sediaan" : "';
            temp += dataMerek[i].sediaan;
            temp += '" , "tidak_dipuyer" : "';
            temp += dataMerek[i].tidak_dipuyer;
            temp += "\" }' data-subtext='";

            for (var e = 0; e < dataMerek[i].komposisi.length; e++) {
                temp += "<br/>";
                temp += dataMerek[i].komposisi[e];
            }

            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";
            temp += dataMerek[i].peringatan;
            temp += "' data-fornas='";
            temp += dataMerek[i].fornas;
            temp += "' data-alternatif='";
            temp += dataMerek[i].alternatif;
            temp += "'>";
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    " <strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += "</option>";
        }
    }

    $("#ddlNamaObat").html(temp).selectpicker("refresh");

    $("#keterangan_auto").html(berat_badan);
    $("#keterangan_auto_keterangan").removeClass("hide").hide().slideDown(500);
    $("#ddlNamaObat").val("").selectpicker("refresh");
    $("#ddlAturanMinum").val("").selectpicker("refresh");
    $("#ddlsigna").val("").selectpicker("refresh");
    $("#txtjumlah").val("");
    $(".auto").hide(500);
    $("#btn_auto_off").show(500);
    namaObatFocus();
}

function customOption2a(dataMerek, berat_badan) {
    console.log("customOption2a");

    var id = getIdMerek();

    dataMerek = JSON.parse(dataMerek);
    var temp = "";
    for (var i = 0; i < dataMerek.length; i++) {
        var doses = JSON.stringify(dataMerek[i].doses);

        if (dataMerek[i].merek_id == id) {
            temp += "<option data-dose='";
            temp += doses;
            temp += '\' data-custom-value=\'{ "formula_id" : "';
            temp += dataMerek[i].formula_id;
            temp += '", "rak_id" : "';
            temp += dataMerek[i].rak_id;
            temp += '", "merek_id" : "';
            temp += dataMerek[i].merek_id;
            temp += '", "harga_beli" : "';
            temp += dataMerek[i].harga_beli;
            temp += '" , "aturan_minum_id" : "';
            temp += dataMerek[i].aturan_minum_id;
            temp += '" , "harga_jual" : "';
            temp += dataMerek[i].harga_jual;
            temp += '" , "sediaan" : "';
            temp += dataMerek[i].sediaan;
            temp += '" , "tidak_dipuyer" : "';
            temp += dataMerek[i].tidak_dipuyer;
            temp += '" }\' selected="selected" data-subtext=\'';

            for (var e = 0; e < dataMerek[i].komposisi.length; e++) {
                temp += "<br/>";
                temp += dataMerek[i].komposisi[e];
            }

            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";

            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";
            temp += dataMerek[i].peringatan;
            temp += "' data-fornas='";
            temp += dataMerek[i].fornas;
            temp += "' data-alternatif='";
            temp += dataMerek[i].alternatif;
            temp += "'>";
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    " <strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += "</option>";
        } else {
            temp += "<option data-dose='";
            temp += doses;
            temp += '\' data-custom-value=\'{ "formula_id" : "';
            temp += dataMerek[i].formula_id;
            temp += '", "rak_id" : "';
            temp += dataMerek[i].rak_id;
            temp += '", "merek_id" : "';
            temp += dataMerek[i].merek_id;
            temp += '", "harga_beli" : "';
            temp += dataMerek[i].harga_beli;
            temp += '" , "aturan_minum_id" : "';
            temp += dataMerek[i].aturan_minum_id;
            temp += '" , "harga_jual" : "';
            temp += dataMerek[i].harga_jual;
            temp += '" , "sediaan" : "';
            temp += dataMerek[i].sediaan;
            temp += '" , "tidak_dipuyer" : "';
            temp += dataMerek[i].tidak_dipuyer;
            temp += "\" }' data-subtext='";

            for (var e = 0; e < dataMerek[i].komposisi.length; e++) {
                temp += "<br/>";
                temp += dataMerek[i].komposisi[e];
            }
            temp += "' value='";
            temp += dataMerek[i].merek_id;
            temp += "' data-peringatan='";
            temp += dataMerek[i].peringatan;
            temp += "' data-fornas='";
            temp += dataMerek[i].fornas;
            temp += "' data-alternatif='";
            temp += dataMerek[i].alternatif;
            temp += "'>";
            temp += dataMerek[i].merek;
            if (tipe_asuransi_id == 5) {
                temp +=
                    " <strong>(" + uang(dataMerek[i].harga_beli) + ")</strong>";
            }
            temp += "</option>";
        }
    }
    $("#ddlNamaObat").html(temp).selectpicker("refresh");
    $("#keterangan_auto").html(berat_badan);
    $("#keterangan_auto_keterangan").removeClass("hide").hide().slideDown(500);
    $("#ddlNamaObat").val("").selectpicker("refresh");
    $("#ddlAturanMinum").val("").selectpicker("refresh");
    $("#ddlsigna").val("").selectpicker("refresh");
    $("#txtjumlah").val("");
    $(".auto").hide(500);
    $("#btn_auto_off").show(500);
}

function getIdMerek() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.merek_id;
    } else {
        var id = "";
    }

    return id;
}
function getIdFormula() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.formula_id;
    } else {
        var id = "";
    }
    return id;
}
function getTipeFormulaId() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.tipe_formula_id;
    } else {
        var id = "";
    }

    return id;
}

function getRakId() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.rak_id;
    } else {
        var id = "";
    }
    return id;
}
function getFornas() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var fornas = $("#ddlNamaObat option:selected").attr("data-fornas");
    } else {
        var fornas = "";
    }

    return fornas;
}
function getHargaJual() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var kali_obat = $("#kali_obat").val();
        console.log("kali_obat = " + kali_obat);
        var harga_jual = merek.harga_jual * parseInt(kali_obat);
    } else {
        var harga_jual = "";
    }
    return harga_jual;
}
function getHargaBeli() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var harga_beli = merek.harga_beli;
    } else {
        var harga_beli = "";
    }
    return harga_beli;
}
function getAturanMinumId() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.aturan_minum_id;
    } else {
        var id = "";
    }
    return id;
}
function getMerek() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var id = $("#ddlNamaObat option:selected").text();
    } else {
        var id = "";
    }
    return id;
}
function getSediaan() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.sediaan;
    } else {
        var id = "";
    }
    return id;
}
function getTidakDipuyer() {
    var merek = $("#ddlNamaObat").val();
    if (merek != "") {
        var data_custom = $("#ddlNamaObat option:selected").attr(
            "data-custom-value"
        );
        merek = JSON.parse(data_custom);
        var id = merek.tidak_dipuyer;
    } else {
        var id = "";
    }
    return id;
}

function rowdel(control) {
    var MyArray = JSON.parse($(control).val());
    $("#legendpop").popover("hide");

    data.splice(MyArray[0].id, MyArray.length);

    var string = JSON.stringify(data);
    $("#terapi").val(string);
    var resep = resepJson(string);
    viewResep(resep[1]);
    if ($("#puyer").val() == "0" && $("#boolAdd").val() == "0") {
        $("#boolSirupPuyer").val("0");
    }

    var sig = "";

    if (data.length > 0) {
        sig = data[data.length - 1].signa;
    }

    if (sig == "Puyer" && $("#boolSirupPuyer").val() == "0") {
        $("#tipeResep").val("1");
        hideTipeResepPuyer(null);
        tipePuyer();
    } else if (sig == "Add" && $("#boolSirupPuyer").val() == "0") {
        $("#tipeResep").val("2");
        hideTipeResepSirup2(null);
        tipeSirup();
    } else if ($("#boolSirupPuyer").val() == "0") {
        //bila yang terakhir adalah yang normal
        // direset pilihan signa, aturanminum, dan jummlah
        $("#tipeResep")
            .closest("div")
            .find(".btn-info")
            .fadeOut("500", function () {
                $(this).remove();
            });

        $("#tipeResep")
            .closest("div")
            .find(".btn-primary")
            .fadeOut("500", function () {
                $(this).remove();
            });

        $("#ddlsigna")
            .val("")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeIn(500);
        $("#tipeResep")
            .val("0")
            .selectpicker("refresh")
            .closest("div")
            .find(".btn-white")
            .closest("div")
            .fadeIn(500);
        $("#ddlAturanMinum")
            .val("")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeIn(500);
        $("#txtjumlah").val("").selectpicker("refresh").fadeIn(500);
        //jika tipe standar, maka pilihan nama obat dikembalikan lagi, semua resep tersedia
        optionSemua(null);
        $("#boolSirupPuyer").val("0");
    }
}

function sesuaikanInputResep(ID_MER) {
    if (
        $("#tipeResep").val() == "0" &&
        $("#ddlNamaObat option:selected").text().includes("Add Sirup")
    ) {
        $("#txtjumlah").val("").fadeIn(500);
        optionSemua(ID_MER);
    }
    //tipe resep 1 = puyer
    if ($("#tipeResep").val() == "1" && $("#boolSirupPuyer").val() == "0") {
        tipePuyer();
        //tipe resep 2 = add
    } else if (
        $("#tipeResep").val() == "2" &&
        $("#boolSirupPuyer").val() == "0"
    ) {
        tipeSirup();
    } else if (
        $("#tipeResep").val() == "0" &&
        $("#boolSirupPuyer").val() == "1"
    ) {
        $("#boolSirupPuyer").val("0");
        resetSignaAturanMinum();
        optionSemua(ID_MER);
        console.log("2");
    } else if ($("#tipeResep").val() == "0" || $("#tipeResep").val() == "") {
        resetSignaAturanMinum();
        console.log("3");
    }
}

function sesuaikanResep() {
    // bila yang terakhir ditinggal kan Add Sirup
    if ($("#boolAdd").val() == "1") {
        $("#tipeResep")
            .closest("div")
            .find(".btn-white")
            .closest("div")
            .fadeOut("400", function () {
                var button =
                    '<button class="btn btn-primary btn-block" onclick="selesaiAdd(this);return false;" id="selesaikanAdd">Selesaikan Sirup</button>';
                $("#tipeResep")
                    .closest("div")
                    .prepend(button)
                    .hide()
                    .fadeIn(400);
            });
        //signa -2 adalah add sirup
        $("#ddlsigna")
            .val("-2")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeOut(500);
        //aturan minum juga ditentukan saja dengan id 1 (sesuadah makan)
        $("#ddlAturanMinum")
            .val("1")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeOut(500);
        //pada keadaan tipe resep sirup, pilihan pertam selalu sirup, maka ID_SEDIAAN lain selain 3 (sirup), dihilangkan
        optionPuyer(null);
        $("#txtjumlah").val("").selectpicker("refresh").fadeIn(500);
        namaObatFocus();
        //Bila yang terakhir ditinggalkan adalah Puyer
    } else if ($("#puyer").val() == "1") {
        $("#tipeResep")
            .closest("div")
            .find(".btn-white")
            .closest("div")
            .fadeOut("400", function () {
                var button =
                    '<button class="btn btn-info btn-block" onclick="selesaiPuyer(this);return false;" id="selesaikanPuyer">Selesaikan Puyer</button>';
                $("#tipeResep")
                    .closest("div")
                    .prepend(button)
                    .hide()
                    .fadeIn(400);
            });
        $("#ddlsigna")
            .val("-1")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeOut(500);
        $("#ddlAturanMinum")
            .val("1")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeOut(500);
        $("#txtjumlah").val("").selectpicker("refresh").fadeIn(500);
        optionPuyer(null);
        namaObatFocus();
    } else {
        //bila yang terakhir adalah yang normal
        // direset pilihan signa, aturanminum, dan jummlah
        $("#tipeResep")
            .closest("div")
            .find(".btn-info")
            .fadeOut("500", function () {
                $(this).remove();
            });

        $("#tipeResep")
            .closest("div")
            .find(".btn-primary")
            .fadeOut("500", function () {
                $(this).remove();
            });

        $("#ddlsigna")
            .val("")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeIn(500);
        $("#tipeResep")
            .val("0")
            .selectpicker("refresh")
            .closest("div")
            .find(".btn-white")
            .closest("div")
            .fadeIn(500);
        $("#ddlAturanMinum")
            .val("")
            .selectpicker("refresh")
            .closest(".input-group")
            .fadeIn(500);
        $("#txtjumlah").val("").selectpicker("refresh").fadeIn(500);
        //jika tipe standar, maka pilihan nama obat dikembalikan lagi, semua resep tersedia
        optionSemua(null);
        $("#boolSirupPuyer").val("0");
    }
}

function tipePuyer() {
    $("#boolSirupPuyer").val("1");
    $("#puyer").val("1");
    $("#tipeResep")
        .closest("div")
        .find(".btn-white")
        .closest("div")
        .fadeOut("400", function () {
            var button =
                '<button class="btn btn-info btn-block" onclick="selesaiPuyer(this);return false;" id="selesaikanPuyer">Selesaikan Puyer</button>';
            $("#tipeResep").closest("div").prepend(button).hide().fadeIn(400);
        });
}

function tipeSirup() {
    $("#boolSirupPuyer").val("1");
    $("#tipeResep")
        .closest("div")
        .find(".btn-white")
        .closest("div")
        .fadeOut("400", function () {
            var button =
                '<button class="btn btn-primary btn-block" onclick="selesaiAdd(this);return false;" id="selesaikanAdd">Selesaikan Sirup</button>';
            $("#tipeResep").closest("div").prepend(button).hide().fadeIn(400);
        });

    optionPuyer(null);
    $("#txtjumlah").val("").selectpicker("refresh").fadeIn(500);
}

function hideTipeResepPuyer(id) {
    $("#ddlsigna")
        .val("-1")
        .selectpicker("refresh")
        .closest(".input-group")
        .fadeOut(500);
    $("#ddlAturanMinum")
        .val("1")
        .selectpicker("refresh")
        .closest(".input-group")
        .fadeOut(500);
    optionPuyer(id);
}

function hideTipeResepSirup(id) {
    //signa -2 adalah add sirup
    $("#ddlsigna")
        .val("-2")
        .selectpicker("refresh")
        .closest(".input-group")
        .fadeOut(500);
    //jumlah dihilangkan dan ditentukan nilainya adalah 1, karena tidak mungkin add banyak sirup
    $("#txtjumlah").val("1").selectpicker("refresh").fadeOut(500);
    //aturan minum juga ditentukan saja dengan id 1 (sesuadah makan)
    $("#ddlAturanMinum")
        .val("1")
        .selectpicker("refresh")
        .closest(".input-group")
        .fadeOut(500);
    //pada keadaan tipe resep sirup, pilihan pertam selalu sirup, maka ID_SEDIAAN lain selain 3 (sirup), dihilangkan
    optionSyrup(id);
}
function hideTipeResepSirup2(id) {
    //signa -2 adalah add sirup
    $("#ddlsigna")
        .val("-2")
        .selectpicker("refresh")
        .closest(".input-group")
        .fadeOut(500);
    //jumlah dihilangkan dan ditentukan nilainya adalah 1, karena tidak mungkin add banyak sirup
    $("#txtjumlah").val("1").selectpicker("refresh").fadeOut(500);
    //aturan minum juga ditentukan saja dengan id 1 (sesuadah makan)
    $("#ddlAturanMinum")
        .val("1")
        .selectpicker("refresh")
        .closest(".input-group")
        .fadeOut(500);
    //pada keadaan tipe resep sirup, pilihan pertam selalu sirup, maka ID_SEDIAAN lain selain 3 (sirup), dihilangkan
    optionPuyer(id);
}

function submitTindakan() {
    var valJsonAwal = $("#selectTindakan").val();
    valJson = $.parseJSON(valJsonAwal);
    var biaya = valJson.biaya;
    var jenis_tarif_id = valJson.jenis_tarif_id;
    var tarif = $("#selectTindakan option:selected").text();
    var keterangan_tindakan = $.trim($("#keteranganTindakan").val());

    var jenis_tarif_id_rapid_antibodi = $(
        "#jenis_tarif_id_rapid_antibodi"
    ).val();
    var jenis_tarif_id_rapid_antigen = $("#jenis_tarif_id_rapid_antigen").val();
    var jenis_tarif_id_gula_darah = $("#jenis_tarif_id_gula_darah").val();
    if (
        (jenis_tarif_id == jenis_tarif_id_rapid_antibodi || // jenis tarif rapid test
            jenis_tarif_id == jenis_tarif_id_rapid_antigen || // jenis tarif rapid test antigen
            jenis_tarif_id == jenis_tarif_id_gula_darah) && // jenis tarif gula darah
        keterangan_tindakan == ""
    ) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Keterangan Tindakan Harus Diisi!!",
        });
    } else {
        if (valJsonAwal != "") {
            inputTindakan(jenis_tarif_id, tarif, biaya, keterangan_tindakan);
        } else {
            validasi("#selectTindakan", "Harus Diisi!");
            resetInputTIndakan();
        }
        optionBilaNebuBpjs();
    }
}

function viewTindakan(MyArray) {
    var temp = "";
    for (var i = 0; i < MyArray.length; i++) {
        temp += "<tr>";
        temp += "<td>" + MyArray[i].jenis_tarif + "</td>";
        temp += "<td>" + MyArray[i].keterangan_tindakan + "</td>";
        temp +=
            '<td><button class="btn btn-danger btn-xs" value="' +
            i +
            '" onclick="tindakanDel(this)">hapus</button></td>';
        temp += "</tr>";
    }

    $("#ajaxTindakan").html(temp);
    $("#tindakan").val(JSON.stringify(MyArray));
    var temp = "";
    var biaya = 0;
    for (var i = 0; i < MyArray.length; i++) {
        if (MyArray[i].biaya > 0) {
            temp += "<tr>";
            temp += "<td>" + MyArray[i].jenis_tarif + "</td>";
            temp += '<td class="uang">' + MyArray[i].biaya + "</td>";
            temp += "</tr>";

            biaya += MyArray[i].biaya;
        }
    }

    $("#dibayarTIndakanBpjs").html(temp);
    $("#TotalDibayarTindakanBPJS").html(biaya);
    rupiah();
    bpjsBayar();
}

function tindakanDel(control) {
    var i = $(control).val();
    deleteTindakan(i);
    var transaksi_periksa_key_yang_akan_dihapus = "";
    var tindakan_gigi_key_yang_akan_dihapus = "";
    var taksonomi_gigi_key_yang_akan_dihapus = "";
    var tindakan_gigi_template = tindakanGigiArray();
    var transaksi_periksa_key_yang_akan_dihapus = parseInt(i) + 2;

    console.log("----------------------");
    console.log("transaksi_periksa_key_yang_akan_dihapus");
    console.log(transaksi_periksa_key_yang_akan_dihapus);
    console.log("i");
    console.log(i);
    console.log("----------------------");

    $.each(tindakan_gigi_template, function (index, value) {
        if (value != null && value.length > 0) {
            for (let i = 0, len = value.length; i < len; i++) {
                if (
                    transaksi_periksa_key_yang_akan_dihapus ==
                    value[i].transaksi_periksa_key
                ) {
                    console.log(tindakan_gigi_key_yang_akan_dihapus);
                    tindakan_gigi_key_yang_akan_dihapus = i;
                    taksonomi_gigi_key_yang_akan_dihapus = index;
                    console.log("----------------------");
                    console.log("tindakan_gigi_key_yang_akan_dihapus");
                    console.log(tindakan_gigi_key_yang_akan_dihapus);
                    console.log("taksonomi_gigi_key_yang_akan_dihapus");
                    console.log(taksonomi_gigi_key_yang_akan_dihapus);
                    console.log("----------------------");
                    break;
                }
            }
        }
    });

    if (
        taksonomi_gigi_key_yang_akan_dihapus !== "" &&
        tindakan_gigi_key_yang_akan_dihapus !== ""
    ) {
        tindakan_gigi_template[taksonomi_gigi_key_yang_akan_dihapus].splice(
            tindakan_gigi_key_yang_akan_dihapus,
            1
        );

        viewTindakanGigiOnly(tindakan_gigi_template);
        viewKeadaanGigi();
    }
}

function resetInputTIndakan() {
    html = '<input type="text" class="form-control" id="keteranganTindakan">';
    $("#keteranganTindakan")
        .closest("tr")
        .find(".keteranganTindakan")
        .html(html);
    $("#keteranganTindakan").val("");
    $("#selectTindakan")
        .val(null)
        .selectpicker("refresh")
        .closest("tr")
        .find(".btn-white")
        .focus();
}

function dirujuk() {
    $("#confirmRujuk").hide();
    $("#infoRujuk").removeClass("hide").hide().slideDown(500);
    $("#tujuan_rujuk2").focus();
}

function tidakDirujuk() {
    clearRujuk();
    // submit berhasil
    $("#submitFormPeriksa").click();
}

function rujukanSelesai() {
    var tujuan = $("#tujuan_rujuk2").val();
    if (tujuan == "") {
        validasi("#tujuan_rujuk2", "Harus Diisi!");
    } else {
        $("#tujuan_rujuk").val($("#tujuan_rujuk2").val());
        $("#alasan_rujuk").val($("#alasan_rujuk2").val());
        $("#submitFormPeriksa").click();
    }
}

function cancelRujukan() {
    $("#modal-id").modal("hide");
    clearRujuk();
}

function serial() {
    console.log($("#submitPeriksa").serializeArray());
}

function clearRujuk() {
    $("#tujuan_rujuk").val("");
    $("#alasan_rujuk").val("");
}

function tabResepActive() {
    console.log("yeya");
    namaObatFocus();
}

function getTipeAsuransiId(asuransi_id) {
    return $("#asuransi_id option:selected").attr("data-tipe-asuransi");
}

function diagnosaChange() {
    var asuransi_id = $("#asuransi_id").val();
    var pasien_id = $("#pasien_id").val();
    var berat_badan = $("#bb_input").val();
    var diagnosa_id = $("#ddlDiagnosa").val();
    var staf_id = $("#staf_id").val();

    if ($("#asuransi_id option:selected").attr("data-tipe-asuransi") == "5") {
        $.post(
            base + "/poli/ajax/diagcha",
            {
                diagnosa_id: $("#ddlDiagnosa").val(),
                pasien_id: pasien_id,
            },
            function (data) {
                if (data["tidak_boleh_dirujuk"] == "1") {
                    $("#keterangan_boleh_dirujuk").empty();
                    if (
                        $("#ddlDiagnosa").val() != "" ||
                        $("#ddlDiagnosa").val() != null
                    ) {
                        var diagnosa = $("#ddlDiagnosa option:selected").text();
                        var text =
                            '<div class="alert alert-danger" id="isi_pesan_fornas">' +
                            diagnosa +
                            " <strong>tidak boleh DIRUJUK </strong> pilih diagnosa lain (menurut ICD10) bila pasien memang benar2 harus dirujuk</div>";
                        $("#keterangan_boleh_dirujuk")
                            .prepend(text)
                            .hide()
                            .fadeIn(500);
                    }
                } else {
                    $("#keterangan_boleh_dirujuk").empty();
                }
                if (
                    data["ganti_diagnosa"] //jika asuransi bpjs dan diagnosa dm dan ht, maka minta dokter untuk menempatkan diagnosa di diagnosa tambahan
                ) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Diagnosa Diabetes dan HT silahkan tempatkan di Diagnosa Tambahan, Mohon gunakan Diagnosa Lain untuk Diagnosa Utama",
                    });
                    $("#ddlDiagnosa").val("").selectpicker("refresh");
                }
            }
        );
    }
    // AUTO perscription generator untuk mengenerate SOP terapi
    generate();
    var str1 = "";
    if ($("#ddlDiagnosa").val() != "") {
        str1 = $("#ddlDiagnosa option:selected").text();
    }
    // alert(str1);
    if (str1.indexOf("J45") != -1) {
        $("#lblDiagnosa").attr({
            title: "Bila Asma Berat",
            "data-original-title": "Bila Asma Berat",
            "data-content":
                "Jika ASMA BERAT, berikan bersama dexa inj IV 2 ampul, dan prednison 40 tab hr 1-2 :3x3, hr 3-4 : 3x2, hr 5-7 : 3x1, Decafil 20 tablet, termasuk untuk pasien BPJS",
        });
        $("#lblDiagnosa").popover("show");
    } else {
        $("#lblDiagnosa").popover("hide");
    }
}
function namaObatFocus() {
    $("#ddlNamaObat").closest("div").find(".btn-white").focus();
}
function clearResep() {
    $("#terapi").val("[]");
    data = [];
    viewResep("");
    namaObatFocus();
}
function generatePerscription() {
    var result_array = temp_sop_terapi;
    i_sop_terapi = i_sop_terapi + 1;
    var i = parseInt(i_sop_terapi) + 1;
    if (result_array[i_sop_terapi]) {
        var terapi = result_array[i_sop_terapi]["terapi"];
        terapi = JSON.stringify(terapi);
        if (i == length_sop_terapi) {
            i_sop_terapi = -1;
        }
        data = JSON.parse(terapi);
        $("#terapi").val(terapi);
        viewResep(resepJson(terapi)[1]);
        $("#tampungan_sop_terapi").html(i + "/" + length_sop_terapi);
    }
}

function viewResep(control) {
    $("#ajax5").html(control);
    //bagian ini khusus untuk tipe_asuransi == 4 / flat
    if ($("#plafon").length > 0) {
        var totalBiayaObat = 0;

        var resep = $("#terapi").val();
        resep = JSON.parse(resep);
        var harga_jual = 0;
        for (var i = 0; i < resep.length; i++) {
            harga_jual = resep[i].harga_jual_ini;
            totalBiayaObat +=
                harga_jual * resep[i].jumlah * $("#kali_obat").val();
        }
        var plafon = $("#plafon_total").val() - totalBiayaObat;
        $("#plafon").html(plafon);

        if (plafon < 0) {
            $("#uangKekuranganFlat").html(rataAtas5000(Math.abs(plafon)));

            if ($("#kekuranganFlat").hasClass("hide")) {
                $("#kekuranganFlat").removeClass("hide");
            }
        } else {
            if (!$("#kekuranganFlat").hasClass("hide")) {
                $("#kekuranganFlat").addClass("hide");
            }
        }
    }

    if ($("#bilaTipeBPJS").length > 0) {
        var tempDibayarPasien = "";
        var tempDibayarBPJS = "";
        var totalBiaya = 0;
        var biaya_ini = 0;
        var dibayar_bpjs = 0;
        for (var i = 0; i < data.length; i++) {
            if (data[i].fornas == "0") {
                biaya_ini =
                    data[i].harga_jual_ini *
                    data[i].jumlah *
                    $("#kali_obat").val();
                totalBiaya += biaya_ini;
                tempDibayarPasien += "<tr>";
                tempDibayarPasien += "<td>" + data[i].merek_obat + "</td>";
                tempDibayarPasien += "<td>" + data[i].jumlah + "</td>";
                tempDibayarPasien += "</tr>";
            } else {
                dibayar_bpjs +=
                    parseInt(data[i].harga_beli_satuan) *
                    parseInt(data[i].jumlah);

                tempDibayarBPJS += "<tr>";
                tempDibayarBPJS += "<td>" + data[i].merek_obat + "</td>";
                tempDibayarBPJS +=
                    "<td class='text-right'>" + data[i].jumlah + "</td>";
                var total_per_item =
                    parseInt(data[i].jumlah) *
                    parseInt(data[i].harga_beli_satuan);
                tempDibayarBPJS +=
                    "<td class='text-right'>" + uang(total_per_item) + "</td>";
                tempDibayarBPJS += "</tr>";
            }
        }

        updatePlafon(dibayar_bpjs);
        totalBiaya = rataAtas5000(totalBiaya);

        $("#bilaTipeBPJS").html(tempDibayarPasien);
        $("#obat_dibayar_bpjs_container").html(tempDibayarBPJS);
        $("#totalBilaTipeBPJS").html(totalBiaya);
        rupiah();
        bpjsBayar();
    }
    $("#peringatan").empty();
}

function generate() {
    var dataEntry = {
        asuransi_id: $("#asuransi_id").val(),
        pasien_id: $("#pasien_id").val(),
        berat_badan: $("#bb_input").val(),
        diagnosa_id: $("#ddlDiagnosa").val(),
        staf_id: $("#staf_id").val(),
        _token: $("#token").val(),
    };

    var terapi = $("#terapi").val();

    if ($("#hamil").val() != "1" && (terapi == "" || terapi == "[]")) {
        $.post(base + "/poli/ajax/sopterapi", dataEntry, function (result) {
            result = $.trim(result);
            if (!isJsonString(result)) {
                console.log("ini lho errornya", result);
            }
            var result_array = JSON.parse(result);
            temp_sop_terapi = result_array;
            length_sop_terapi = result_array.length;

            if (result_array[0]) {
                var terapi = result_array[0]["terapi"];
                terapi = JSON.stringify(terapi);
                data = JSON.parse(terapi);
                $("#terapi").val(terapi);
                viewResep(resepJson(terapi)[1]);
                $("#tampungan_sop_terapi").html("1/" + length_sop_terapi);
                i_sop_terapi = 0;
            } else {
                var terapi = "[]";
                $("#terapi").val(terapi);
                viewResep(resepJson(terapi)[1]);
                temp_sop_terapi = [];
                $("#tampungan_sop_terapi").html("0");
                i_sop_terapi = 0;
            }
        }).fail(function (data) {
            console.log(data);
            // Error...
            var errors = $.parseJSON(data.responseText);

            console.log(errors);

            $.each(errors, function (index, value) {
                $.gritter.add({
                    title: "Error",
                    text: value,
                });
            });
        });
    }
}
function generate2() {
    var dataEntry = {
        asuransi_id: $("#asuransi_id").val(),
        pasien_id: $("#pasien_id").val(),
        berat_badan: $("#bb_input").val(),
        diagnosa_id: $("#ddlDiagnosa").val(),
        staf_id: $("#staf_id").val(),
        _token: $("#token").val(),
    };

    var terapi = $("#terapi").val();
    if ($("#hamil").val() != "1" && $("#dibantu").val() == "1") {
        $.post(base + "/poli/ajax/sopterapi", dataEntry, function (result) {
            result = $.trim(result);

            var result_array = JSON.parse(result);
            temp_sop_terapi = result_array;
            length_sop_terapi = result_array.length;

            if (result_array[0]) {
                var terapi = result_array[0]["terapi"];
                terapi = JSON.stringify(terapi);
                data = JSON.parse(terapi);
                $("#terapi").val(terapi);
                viewResep(resepJson(terapi)[1]);
                $("#tampungan_sop_terapi").html("1/" + length_sop_terapi);
                i_sop_terapi = 0;
            } else {
                var terapi = "[]";
                $("#terapi").val(terapi);
                viewResep(resepJson(terapi)[1]);
                temp_sop_terapi = [];
                $("#tampungan_sop_terapi").html("0");
                i_sop_terapi = 0;
            }
        });
    }
}
function hasil() {
    var presentasi = $("#usg_presentasi").val();
    var patologis = "";
    var sex = $("#usg_sex").val();
    var plasenta = $("#usg_plasenta").val();
    var ltp = $("#usg_ltp").val();
    var umur_kehamilan = $("#uk").val();
    var efw = $("#usg_efw").val();
    var djj = $("#usg_djj").val();
    var riw_obs =
        "G" + $("#G").val() + "P" + $("#P").val() + "A" + $("#A").val();
    var afi = $("#total_afi").val();
    var uk_usg = "";

    var minggu = $.trim(umur_kehamilan.split("minggu")[0]);
    console.log("umur_kehamilan = " + umur_kehamilan);
    console.log("minggu = " + minggu);
    if (minggu >= 12 && minggu <= 24) {
        uk_usg = $("#BPD_w").val() + " minggu " + $("#BPD_d").val() + " hari";
    } else if (minggu >= 24) {
        uk_usg = $("#FL_w").val() + " minggu " + $("#FL_d").val() + " hari";
    }
    console.log("uk_usg = " + uk_usg);
    var status_afi = "cukup";
    if (parseInt(afi) > 8) {
        status_afi = "berlebihan";
        patologis += "polihydramnion, ";
    } else if (parseInt(afi) < 2) {
        status_afi = "kurang";
        patologis += "oligohydramnion, ";
    }
    var djj_status = "normal";
    if (parseInt(djj) > 160) {
        djj_status = "tinggi";
        patologis += "takikardia fungsional dd/ Gawat Janin, ";
    } else if (parseInt(djj) < 120) {
        djj_status = "rendah";
        patologis += "Gawat Janin, ";
    }

    if (ltp == "0") {
        ltp = "tidak ada";
    }
    var temp =
        "Janin presentasi " +
        presentasi +
        ", denyut jantung janin " +
        djj_status +
        " " +
        djj +
        " x/mnt, " +
        ltp +
        " lilitan tali pusat, perikiraan berat janin " +
        efw +
        " gr";
    temp += ", umur kehamilan menurut USG saat ini = " + uk_usg;
    temp +=
        ", jenis kelamin " +
        sex +
        ", plasenta di " +
        plasenta +
        ", cairan ketuban 1 kantong terdalam " +
        afi +
        ", " +
        status_afi +
        ", " +
        riw_obs +
        "H" +
        umur_kehamilan +
        ", Janin presentasi " +
        presentasi +
        ", " +
        patologis;

    var periksa_lagi = "4 minggu lagi";
    if (minggu >= 37) {
        periksa_lagi = "1 minggu lagi";
    } else if (minggu >= 32) {
        periksa_lagi = "2 minggu lagi";
    }

    $("#saran").val("periksa lagi " + periksa_lagi);

    console.log(temp);
    $("#kesimpulan").val(temp);
}

function riwObsG() {
    if ($("#G").val() != "" && $("#G").val() < 10) {
        var pasien_id = $("#pasien_id").val();
        $.post(
            base + "/anc/registerhamil",
            { G: $("#G").val(), pasien_id: pasien_id },
            function (data, textStatus, xhr) {
                if (data != "") {
                    console.log(data);
                    if (data.buku != null) {
                        var buku = data.buku.id;
                    } else {
                        var buku = 3;
                    }
                    $("#hpht").val(data.hpht);
                    $("#uk").val(data.uk);
                    $("#P").val(data.p);
                    $("#A").val(data.a);
                    $("#tanggal_lahir_anak_terakhir").val(
                        data.tanggal_lahir_anak_terakhir
                    );
                    $("#golongan_darah").val(data.golongan_darah);
                    $("#rencana_penolong").val(data.rencana_penolong);
                    $("#rencana_tempat").val(data.rencana_tempat);
                    $("#rencana_pendamping").val(data.rencana_pendamping);
                    $("#rencana_transportasi").val(data.rencana_transportasi);
                    2;
                    $("#rencana_pendonor").val(data.rencana_pendonor);
                    $("#tb").val(data.tb);
                    $("#jumlah_janin").val(data.jumlah_janin);
                    $("#status_imunisasi_tt_id").val(
                        data.status_imunisasi_tt_id
                    );
                    $("#nama_suami").val(data.nama_suami);
                    $("#buku").val(buku);
                    $("#bb_sebelum_hamil").val(data.bb_sebelum_hamil);
                    $("#riwayat_kehamilan").val(
                        data.riwayat_kehamilan_sebelumnya
                    );
                    uk_exec("uk", "hpht");
                    viewNoFocus();
                }
            }
        );
    } else {
        $(".gpa2").val("");
        $(".panelRiwayat").val("");
        $("#riwayat_kehamilan").val("[]");
        viewNoFocus();
    }
}
function fokusKeAnemnesa() {
    $("#cekFoto").modal("hide");
    $("#cekFoto").on("hidden.bs.modal", function (e) {
        $("#anamnesa").focus();
        $("#labelKecelakaanKerja").on("shown.bs.popover", function () {
            setTimeout(function () {
                $("#labelKecelakaanKerja").popover("hide");
            }, 8000);
        });
        $("#labelKecelakaanKerja").popover("show");
    });
}

function rupiah() {
    $('.uang:not(:contains("Rp."))').each(function () {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html("Rp. " + number + " ,-");
    });
}

function kecelakaanKerjaChange(control) {
    var asuransi_id = $("#asuransi_id").val();
    var kklkk = $(control).val();
    var antrianperiksa_id = $("#antrianperiksa_id").val();
    if (
        $("#asuransi_id option:selected").attr("data-tipe-asuransi") == "5" &&
        kklkk == "1"
    ) {
        $("#pleaseWaitDialog").modal({ backdrop: "static", keyboard: false });
        $.ajax({
            url: base + "/poli/ajax/kkchange",
            type: "POST",
            data: { antrianperiksa_id: antrianperiksa_id },
        })
            .done(function () {
                location.reload(true);
            })
            .fail(function () {
                $("#pleaseWaitDialog").modal("hide");
                console.log("error");
            });
    }
}

function asuransiIdChange(control) {
    var asuransi_id = $(control).val();
    console.log("asuransi_id", asuransi_id);
    var antrianperiksa_id = $("#antrianperiksa_id").val();
    $("#pleaseWaitDialog").modal({ backdrop: "static", keyboard: false });
    $.ajax({
        url: base + "/poli/ajax/asuridchange",
        type: "POST",
        data: {
            asuransi_id: asuransi_id,
            antrianperiksa_id: antrianperiksa_id,
        },
    })
        .done(function () {
            location.reload(true);
        })
        .fail(function () {
            $("#pleaseWaitDialog").modal("hide");
            console.log("error");
        })
        .always(function () {
            console.log("complete");
        });
}
function bpjsBayar() {
    var asuransi_id = $("#asuransi_id").val();
    if ($("#asuransi_id option:selected").attr("data-tipe-asuransi") == "5") {
        var tindakan = $("#TotalDibayarTindakanBPJS").html();
        var obat = $("#totalBilaTipeBPJS").html();
        if (obat == "Rp. ,-") {
            obat = "Rp. 0,-";
        }
        if (tindakan == "Rp. ,-") {
            tindakan = "Rp. 0,-";
        }
        var total = parseInt(cleanUang(tindakan)) + parseInt(cleanUang(obat));
        $("#jumlahDibayarBpjs").html(total);
        if (total > 0) {
            $("#adaYangDibayar").hide().fadeIn(500);
        } else {
            $("#adaYangDibayar").hide();
        }
        rupiah();
    }
}

function bukanAsmaAkut() {
    var bool = false;
    apakahAsmaAkut(bool);
    var ket =
        "Tindakan BPJS pasien ini tidak ditanggung BPJS, karena bukan asma akut. Tekan pilihan di bawah ini untuk mengubah";
    updateKeteranganNebuBpjs(ket, bool);
}
function asmaAkut() {
    var bool = true;
    apakahAsmaAkut(bool);
    var ket =
        "Nebulizer ditanggung BPJS karena asma akut. Tekan pilihan di bawah ini untuk mengubah ";
    updateKeteranganNebuBpjs(ket, bool);
}

function optionBilaNebuBpjs() {
    var tindakans = tindakansArray();
    var ada_nebu = false;
    for (var i = 0; i < tindakans.length; i++) {
        if (
            tindakans[i].jenis_tarif_id == "102" ||
            tindakans[i].jenis_tarif_id == "103"
        ) {
            ada_nebu = true;
            break;
        }
    }
    if (
        ada_nebu &&
        $("#asuransi_id option:selected").attr("data-tipe-asuransi") == "5"
    ) {
        $("#option_bila_nebu_bpjs").hide().fadeIn(500);
    } else {
        $("#option_bila_nebu_bpjs").fadeOut(500);
    }
}

function tindakansArray() {
    var tindakans = $("#tindakan").val();
    tindakans = $.parseJSON(tindakans);
    return tindakans;
}

function apakahAsmaAkut(ditanggung) {
    if (ditanggung) {
        var keterangan = "(ditanggung)";
        var biaya_anak = 0;
        var biaya_dewasa = 0;
    } else {
        var keterangan = " (TIDAK DITANGGUNG BPJS)";
        var biaya_anak = 45000;
        var biaya_dewasa = 40000;
    }
    var tindakans = tindakansArray();
    for (var i = 0; i < tindakans.length; i++) {
        if (
            tindakans[i].jenis_tarif_id == "102" ||
            tindakans[i].jenis_tarif_id == "103"
        ) {
            var keterangan = tindakans[i].keterangan;
            var jenis_tarif_id = tindakans[i].jenis_tarif_id;
            tindakans.splice(i, 1);
            if (jenis_tarif_id == "102") {
                var tindakan = {
                    jenis_tarif_id: "102",
                    jenis_tarif: "Nebulizer Anak " + keterangan,
                    biaya: biaya_anak,
                    keterangan_tindakan: keterangan,
                };
            } else {
                var tindakan = {
                    jenis_tarif_id: "103",
                    jenis_tarif: "Nebulizer Dewasa " + keterangan,
                    biaya: biaya_dewasa,
                    keterangan_tindakan: keterangan,
                };
            }
            tindakans[tindakans.length] = tindakan;
        }
    }

    var string = JSON.stringify(tindakans);
    $("#tindakan").val(string);
}
function updateKeteranganNebuBpjs(ket, bool) {
    $("#keterangan_nebu_bpjs").html(ket);
    var e = $("#option_bila_nebu_bpjs");
    if (bool) {
        if (e.hasClass("alert-danger") || e.hasClass("alert-warning")) {
            e.removeClass("alert-danger");
            e.removeClass("alert-warning");
            e.addClass("alert-success");
        }
    } else if (e.hasClass("alert-warning") || e.hasClass("alert-success")) {
        e.removeClass("alert-success");
        e.removeClass("alert-warning");
        e.addClass("alert-danger");
    }
    $("#option_bila_nebu_bpjs").hide().fadeIn(500);
}
function bahanHabisPakai() {
    var MyArray = dataTindakan;
    var temp = "";

    for (var i = 0; i < MyArray.length; i++) {
        temp +=
            MyArray[i].jenis_tarif +
            " : " +
            MyArray[i].keterangan_tindakan +
            ", \n";
    }
    console.log(dataTindakan);
    var jsonData = JSON.stringify(dataTindakan);

    $.post(
        base + "/poli/ajax/bhp_tindakan",
        { jsonData: jsonData, _token: $("#token").val() },
        function (data, textStatus, jqXHR) {
            console.log(data);
            var data = $.parseJSON(data);
            if (data.length > 0) {
                var temp = '<div class="alert alert-success">';
                temp +=
                    '<h3 class="text-center">Daftar Bahan Habis Pakai Tindakan</h3>';
                temp += '<table class="table table-condensed"><tbody>';
                for (var i = 0, l = data.length; i < l; i++) {
                    temp += "<tr>";
                    temp +=
                        '<td> R/ <a nowrap="" href="#" onclick="informasi(this); return false; " data-value="' +
                        data[i].merek_id +
                        '" data-toggle="modal" data-target=".bs-example-modal-lg">' +
                        data[i].merek +
                        "</a></td>";
                    temp +=
                        '<td class"text-right"> No : ' +
                        data[i].jumlah +
                        "</td>";
                    temp += "</tr>";
                }
                temp += "</tbody></table>";
                temp +=
                    '<p class="text-center">Tidak Perlu diinput lagi</p></div>';

                $("#bhp_tindakan").html(temp);
            } else {
                $("#bhp_tindakan").html("");
            }
        }
    );

    $("#pemeriksaan_penunjang").val(temp).focus();
}

function dummySubmit() {
    var puyer = $("#puyer").val();
    var boolAdd = $("#boolAdd").val();

    var tindakan = $("#adatindakan").val();
    var tindakans = $.parseJSON($("#tindakan").val());

    if (boolAdd == "1" || puyer == "1") {
        Swal.fire(
            "Oops!",
            "Puyer atau Add Sirup belum selesai. Resep tidak bisa dilanjutkan sebelum diselesaikan",
            "error"
        );
        return false;
    }

    if ($("#anamnesa").val() == "" || $("#ddlDiagnosa").val() == "") {
        Swal.fire(
            "Oops!",
            "Anamnesa dan Diagnosa tidak boleh dikosongkan!!",
            "error"
        );
        $("#tab-status").tab("show");
        if ($("#anamnesa").val() == "") {
            validasi("#anamnesa", "Harus Diisi!");
        }
        if ($("#ddlDiagnosa").val() == "") {
            validasi2("#ddlDiagnosa", "Harus Diisi!");
        }
        return false;
    } else if (tindakan == "1") {
        var tindakanTambahan = 0;
        for (var i = 0; i < tindakans.length; i++) {
            if (
                tindakans[i]["jenis_tarif_id"] != "1" &&
                tindakans[i]["jenis_tarif_id"] != "9" &&
                tindakans[i]["jenis_tarif_id"] != "140"
            ) {
                tindakanTambahan++;
            }
        }
        if (tindakanTambahan == 0) {
            var r = confirm(
                "Apa Anda lupa isi kolom tindakan? Jika anda yakin bahwa tidak ada tindakan tambahan, tekan tombol OK"
            );
            if (r) {
                $("#submitFormPeriksa").click();
            } else {
                return false;
            }
        } else {
            $("#submitFormPeriksa").click();
        }
    } else {
        $("#submitFormPeriksa").click();
    }
}

function refresh() {
    var parameter = { antrianperiksa_id: $("#antrianperiksa_id").val() };
    $.post(base + "/poli/ajax/ambil_gambar", parameter, function (data) {
        console.log("data = " + data);
        data = JSON.parse(data);
        var temp = "";
        for (var i = 0, len = data.length; i < len; i++) {
            if (isEven(i)) {
                temp += '<div class="row">';
            }
            temp += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
            temp +=
                '<img src="' +
                base_s3 +
                "/img/estetika/" +
                data[i].image +
                '" class="img-thumbnails" alt="">';
            temp += "</div>";
            if (isOdd(i)) {
                temp += "</div><br />";
            }
        }
        if (isEven(i) && temp != "") {
            temp += "</div>";
        }
        $("#gambar").html(temp);
    });
}

function selectChange(control) {
    console.log("control");
    console.log(control);
    console.log("3046 selectChange");
    var html = "";
    var tindakan = $(control).val();
    tindakan = $.parseJSON(tindakan);
    var jenis_tarif_id = tindakan["jenis_tarif_id"];

    if (jenis_tarif_id == "403" || jenis_tarif_id == "404") {
        html = '<select class="form-control" id="keteranganTindakan">';
        html += '<option value="" selected="selected"> - Pilih - </option>';
        html += '<option value="negatif">NON REAKTIF / NEGATIF</option>';
        html += '<option value="positif">REAKTIF / POSITIF</option>';
        html += "</select>";
    } else if (
        jenis_tarif_id == "116" // gula darah
    ) {
        html +=
            '<input type="text" placeholder="hanya angka" class="form-control" id="keteranganTindakan" onkeypress="return angka(event)">';
    } else {
        html =
            '<input type="text" class="form-control" id="keteranganTindakan">';
    }
    $(control).closest("tr").find(".keteranganTindakan").html(html);
}
function updatePlafon(dibayar_bpjs) {
    if ($("#periksaex").length > 0) {
        plafon_bpjs_ini =
            parseInt($("#plafon_dikembalikan_karena_ngedit").val()) +
            parseInt($("#plafon_obat_bpjs_by_staf").val());
    }
    var sisa_plafon = parseInt(plafon_bpjs_ini) - parseInt(dibayar_bpjs);
    $("#total_utilisasi_obat_bpjs").html(uang(dibayar_bpjs));
    $("#plafon_obat_bpjs").html(
        uang(plafon_bpjs_ini) +
            " - " +
            uang(dibayar_bpjs) +
            " = <h1>" +
            uang(sisa_plafon) +
            "</h1>"
    );
    $("#obat_dibayar_bpjs").val(sisa_plafon);
}
function changeBB(control) {
    var bb = $(control).val();
    $("#bb_form").val(bb);
    console.log(bb);
}
function inputTindakan(
    jenis_tarif_id,
    jenis_tarif,
    biaya,
    keterangan_tindakan
) {
    var key = dataTindakan.length;
    console.log(3076);
    console.log("dataTindakan");
    console.log(dataTindakan);
    dataTindakan[key] = {
        jenis_tarif_id: jenis_tarif_id,
        jenis_tarif: jenis_tarif,
        biaya: biaya,
        keterangan_tindakan: keterangan_tindakan,
    };
    console.log(3122);
    console.log("dataTindakan");
    console.log(dataTindakan);
    var string = JSON.stringify(dataTindakan);

    $("#tindakan").val(string);

    viewTindakan(dataTindakan);
    resetInputTIndakan();
    bahanHabisPakai();
    return key;
}

function deleteTindakan(i) {
    dataTindakan.splice(i, 1);
    viewTindakan(dataTindakan);
    resetInputTIndakan();
    optionBilaNebuBpjs();
    bahanHabisPakai();
}
function refreshGambar(data) {
    var temp = "";
    if (data.length) {
        temp +=
            '<div id="carousel-gambar-periksa" class="carousel slide" data-ride="carousel">';
        temp += '<ol class="carousel-indicators">';
        var a = 0;
        for (var i = data.length - 1; i >= 0; i--) {
            var active = a == 0 ? 'class="active"' : "";
            temp +=
                '<li data-target="#carousel-gambar-periksa" data-slide-to="' +
                a +
                '" ' +
                active +
                "></li>";
            a++;
        }
        temp += "</ol>";
        temp += '<div class="carousel-inner" role="listbox">';
        var a = 0;
        for (var i = data.length - 1; i >= 0; i--) {
            var active = a == 0 ? " active" : "";
            temp += '<div class="item' + active + '">';
            temp +=
                '<img src="' +
                base_s3_wa +
                "/" +
                data[i].nama +
                '" alt="" class="img-rounded upload"> ';
            temp += "</div>";
            a++;
        }
        temp += "</div>";
        temp +=
            '<a class="left carousel-control" href="#carousel-gambar-periksa" role="button" data-slide="prev">';
        temp +=
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>';
        temp += '<span class="sr-only">Previous</span>';
        temp += "</a>";
        temp +=
            '<a class="right carousel-control" href="#carousel-gambar-periksa" role="button" data-slide="next">';
        temp +=
            '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>';
        temp += '<span class="sr-only">Next</span>';
        temp += "</a>";
        temp += "</div>";
        temp += " ";
    }
    $("#container_gambar_periksa").html(temp);
}
function kirimWaGambar(control) {
    $.post(
        base + "/periksas/notif/inputGambar",
        {
            staf_id: $("#staf_id").val(),
            pasien_id: $("#pasien_id").val(),
            antrian_periksa_id: $("#antrian_periksa_id").val(),
        },
        function (data, textStatus, jqXHR) {
            if (data.terkirim) {
                Swal.fire({
                    icon: "success",
                    title: "Permintaan berhasil terkirim ke " + data.no_telp,
                    showConfirmButton: false,
                    timer: 1500,
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text:
                        "Permintaan ke nomor yang sama ke " +
                        data.no_telp +
                        " dikirim sebelumnya. Silahkan langsung ambil foto",
                });
            }
        }
    );
}


function showFotoZoom(){
    $('#fotozoom').modal('show');
}
    $('.hide-panel').closest('.panel').find('.panel-heading').css('border', '3px border red');
    $('.hide-panel').closest('.panel').find('.panel-heading').css('cursor', 'pointer');
    $('.hide-panel').closest('.panel').find('.panel-heading').click(function(e) {
        if ( $('#resepluar').val() ==  ''){
            $(this).closest('.panel').find('.hide-panel').slideToggle(function(){
                $(this).closest('.panel').find('.resepluar').focus(); 
            });
            $('.unhide-panel:not([src="' + base + '/notfound.jpg"])').toggle();
        }
    });;

function resepJson(result) {
    if (result != "") {
        var MyArray = JSON.parse(result);
    } else {
        var MyArray = "";
    }
    console.log("yeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee");
    console.log("MyArray", MyArray);
    var temp = '<table width="100%">';
    if (MyArray.length > 0) {
        console.log("lebih dari 0");
        console.log("MyArray[0].merek_id", MyArray[0].merek_id, "oke", i);
        for (var i = 0; i < MyArray.length - 1; i++) {
            console.log("thiiiisss", i);
            console.log("MyArray[i].merek_id", MyArray[i].merek_id, "oke", i);
            //Untuk menghitung urutan add sirup yang terakhir

            if (
                MyArray[i].signa.substring(0, 5) == "Puyer" &&
                $("#puyer").val() == "0"
            ) {
                temp += "<tr>";
                temp += '<td style="width:15px">R/</td>';
                temp +=
                    '<td style="text-align:left; width:150px;" nowrap>' +
                    MyArray[i].merek_obat +
                    " <strong>[  " +
                    MyArray[i].rak_id +
                    "  ]</strong></td>";
                temp += "<td> No : " + MyArray[i].jumlah + "</td>";
                temp += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#puyer").val("1");
                } else {
                    $("#puyer").val("0");
                }
            } else if (
                MyArray[i].signa.substring(0, 5) == "Puyer" &&
                $("#puyer").val() == "1"
            ) {
                temp += "<tr>";
                temp += '<td style="width:15px"></td>';
                temp +=
                    '<td style="text-align:left; width:150px;" nowrap>' +
                    MyArray[i].merek_obat +
                    " <strong>[  " +
                    MyArray[i].rak_id +
                    "  ]</strong></td>";
                temp += "<td> No : " + MyArray[i].jumlah + "</td>";
                temp += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#puyer").val("1");
                } else {
                    $("#puyer").val("0");
                }
            } else if (
                MyArray[i].merek_id ==
                    $("#merek_id_kertas_puyer_biasa").val() ||
                MyArray[i].merek_id == $("#merek_id_kertas_puyer_sablon").val()
            ) {
                temp += "<tr>";
                temp += '<td style="width:15px"></td>';
                temp +=
                    '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' +
                    MyArray[i].jumlah +
                    " puyer " +
                    MyArray[i].signa +
                    "</td>";
                temp +=
                    '<td style="border-bottom:1px solid #000;"  nowrap>' +
                    MyArray[i].aturan_minum +
                    "</td>";
                temp += "</tr>";

                $("#puyer").val("0");
            } else if (
                MyArray[i].signa.substring(0, 3) == "Add" &&
                $("#boolAdd").val() == "0"
            ) {
                temp += "<tr>";
                temp += '<td style="width:15px">R/</td>';
                temp +=
                    '<td style="width:150px;text-align:left;" nowrap>' +
                    MyArray[i].merek_obat +
                    " <strong>[  " +
                    MyArray[i].rak_id +
                    "  ]</strong></td>";
                temp += "<td> fls No : " + MyArray[i].jumlah + "</td>";
                temp += "</tr>";
                temp += "<tr>";
                temp += '<td style="text-align:center;" colspan="3">ADD</td>';
                temp += "</tr>";

                $("#boolAdd").val("1");
            } else if (
                MyArray[i].signa.substring(0, 3) == "Add" &&
                $("#boolAdd").val() == "1"
            ) {
                temp += "<tr>";
                temp += '<td style="width:15px"></td>';
                temp +=
                    '<td style="width:150px;text-align:left;" nowrap>' +
                    MyArray[i].merek_obat +
                    " <strong>[  " +
                    MyArray[i].rak_id +
                    "  ]</strong></td>";
                temp += "<td> No : " + MyArray[i].jumlah + "</td>";
                temp += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#boolAdd").val("1");
                } else {
                    $("#boolAdd").val("0");
                }
            } else if (MyArray[i].merek_id == $("#merek_id_add_sirup").val()) {
                temp += "<tr>";
                temp += '<td style="width:15px"></td>';
                temp +=
                    '<td style="width:150px;border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' +
                    MyArray[i].signa +
                    " </td>";
                temp +=
                    '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                temp += "</tr>";

                $("#puyer").val("0");
            } else {
                temp += "<tr>";
                temp += '<td style="width:15px">R/</td>';
                temp +=
                    '<td style="width:150px;text-align:left;" nowrap>' +
                    MyArray[i].merek_obat +
                    " <strong>[  " +
                    MyArray[i].rak_id +
                    "  ]</strong></td>";
                temp += "<td> No : " + MyArray[i].jumlah + "</td>";
                temp += "</tr><tr>";
                temp += '<td style="width:15px"></td>';
                temp +=
                    '<td style="width:150px;border-bottom:1px solid #000;"> S ' +
                    MyArray[i].signa +
                    "</td>";
                temp +=
                    '<td style="border-bottom:1px solid #000;" nowrap>' +
                    MyArray[i].aturan_minum +
                    "</td>";
                temp += "</tr>";
            }
        }
        var a = MyArray.length - 1;
        if (
            MyArray[a].merek_id == $("#merek_id_kertas_puyer_biasa").val() ||
            MyArray[a].merek_id == $("#merek_id_kertas_puyer_sablon").val()
        ) {
            temp += "<tr>";
            temp += '<td style="width:15px"></td>';
            temp +=
                '<td style="width:150px;border-bottom:1px solid #000;" nowrap class="merek">Buat Menjadi ' +
                MyArray[a].jumlah +
                " puyer " +
                MyArray[a].signa +
                "</td>";
            temp +=
                '<td style="border-bottom:1px solid #000;" nowrap>' +
                MyArray[a].aturan_minum +
                "</td>";
            $("#puyer").val("0");
        } else if (MyArray[a].merek_id == $("#merek_id_add_sirup").val()) {
            temp += "<tr>";
            temp += '<td style="width:15px"></td>';
            temp +=
                '<td style="width:150px;border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' +
                MyArray[a].signa +
                "</td>";
            temp += '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';

            $("#boolAdd").val("0");
        } else if (
            MyArray[a].signa.substring(0, 3) == "Add" &&
            $("#boolAdd").val() == "0"
        ) {
            temp += "<tr>";
            temp += '<td style="width:15px">R/</td>';
            temp +=
                '<td style="width:150px;" nowrap>' +
                MyArray[a].merek_obat +
                " <strong>[  " +
                MyArray[a].rak_id +
                "  ]</strong></td>";
            temp += "<td> fls No : " + MyArray[a].jumlah + "</td>";
            temp += "</tr>";
            temp += "<tr>";
            temp += '<td  style="text-align:center;" colspan="3">ADD</td>';

            $("#boolAdd").val("1");

            id_formula_sirup_add = MyArray[a].formula_id;
            console.log("id_formula_sirup_add = " + id_formula_sirup_add);
        } else if (
            MyArray[a].signa.substring(0, 3) == "Add" &&
            $("#boolAdd").val() == "1"
        ) {
            temp += "<tr>";
            temp += '<td style="width:15px"></td>';
            temp +=
                '<td style="width:150px;" nowrap>' +
                MyArray[a].merek_obat +
                " <strong>[  " +
                MyArray[a].rak_id +
                "  ]</strong></td>";
            temp += "<td> No : " + MyArray[a].jumlah + "</td>";
            // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
            if (
                !(
                    (
                        (MyArray[a].formula_id == "150802040" &&
                            id_formula_sirup_add == "150803008") || // Cefadroksil capsul dan Cefadroksil syrup
                        (MyArray[a].formula_id == "150806007" &&
                            id_formula_sirup_add == "150803003") || // Brodamox tablet dan Decamox syrup
                        (MyArray[a].formula_id == "150803047" &&
                            id_formula_sirup_add == "150803006") || // Dexycol capsul dan Dionicol syr
                        (MyArray[a].formula_id == "150806005" &&
                            id_formula_sirup_add == "150921001")
                    ) // Cefixime capsul dan Cefixime syr
                )
            ) {
                addSatu = true;
            }
        } else if (
            MyArray[a].signa.substring(0, 5) == "Puyer" &&
            $("#puyer").val() == "0"
        ) {
            temp += "<tr>";
            temp += '<td style="width:15px">R/</td>';
            temp +=
                '<td style="width:150px;text-align:left;" nowrap>' +
                MyArray[a].merek_obat +
                " <strong>[  " +
                MyArray[a].rak_id +
                "  ]</strong></td>";
            temp += "<td> No : " + MyArray[a].jumlah + "</td>";
        } else if (
            MyArray[a].signa.substring(0, 5) == "Puyer" &&
            $("#puyer").val() == "1"
        ) {
            temp += "<tr>";
            temp += '<td style="width:15px"></td>';
            temp +=
                '<td style="width:150px;text-align:left;" nowrap>' +
                MyArray[a].merek_obat +
                " <strong>[  " +
                MyArray[a].rak_id +
                "  ]</strong></td>";
            temp += "<td> No : " + MyArray[a].jumlah + "</td>";
        } else {
            temp += "<tr>";
            temp += '<td style="width:15px">R/</td>';
            temp +=
                '<td style="width:150px;text-align:left;" nowrap>' +
                MyArray[a].merek_obat +
                " <strong>[  " +
                MyArray[a].rak_id +
                "  ]</strong></td>";
            temp += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp += "</tr><tr>";
            temp += '<td style="width:15px"></td>';
            temp +=
                '<td style="width:150px;border-bottom:1px solid #000;"> S ' +
                MyArray[a].signa +
                "</td>";
            temp +=
                '<td style="border-bottom:1px solid #000;" nowrap>' +
                MyArray[a].aturan_minum +
                "</td>";
        }
    }
    temp += "</tr></table>";
    //=============================================================
    //=============================================================
    //=============================================================
    $("#puyer").val("0");
    $("#boolAdd").val("0");
    var temp2 = '<table class="RESEP table table-condensed"><tbody>';

    var ID_TERAPIGroup = [];

    //lert(MyArray[0].signa);
    if (MyArray.length > 0) {
        for (var i = 0; i < MyArray.length - 1; i++) {
            if (
                MyArray[i].signa.substring(0, 5) == "Puyer" &&
                $("#puyer").val() == "0"
            ) {
                ID_TERAPIGroup = [];
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp2 += "<tr>";
                temp2 += '<td style="width:15px">R/</td>';
                temp2 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp2 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp2 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp2 += "<td></td>";
                temp2 += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#puyer").val("1");
                } else {
                    $("#puyer").val("0");
                }
            } else if (
                MyArray[i].signa.substring(0, 5) == "Puyer" &&
                $("#puyer").val() == "1"
            ) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp2 += "<tr>";
                temp2 += '<td style="width:15px"></td>';
                temp2 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp2 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp2 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp2 += "<td></td>";
                temp2 += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#puyer").val("1");
                } else {
                    $("#puyer").val("0");
                }
            } else if (
                MyArray[i].merek_id ==
                    $("#merek_id_kertas_puyer_biasa").val() ||
                MyArray[i].merek_id == $("#merek_id_kertas_puyer_sablon").val()
            ) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp2 += "<tr>";
                temp2 += '<td style="width:15px"></td>';
                temp2 +=
                    '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' +
                    MyArray[i].jumlah +
                    " puyer " +
                    MyArray[i].signa +
                    "</td>";
                temp2 +=
                    '<td style="border-bottom:1px solid #000;" nowrap>' +
                    MyArray[i].aturan_minum +
                    "</td>";
                temp2 +=
                    "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                    JSON.stringify(ID_TERAPIGroup) +
                    "'>hapus</button></td>";
                temp2 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp2 += "</tr>";

                $("#puyer").val("0");
            } else if (
                MyArray[i].signa.substring(0, 3) == "Add" &&
                $("#boolAdd").val() == "0"
            ) {
                ID_TERAPIGroup = [];
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp2 += "<tr>";
                temp2 += '<td style="width:15px">R/</td>';
                temp2 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>";
                temp2 += "<td> fls No : " + MyArray[i].jumlah + "</td>";
                temp2 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp2 += "<td></td>";
                temp2 += "</tr>";
                temp2 += "<tr>";
                temp2 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                temp2 += '<td class="displayNone"></td>';
                temp2 += "<td></td>";
                temp2 += "</tr>";

                id_formula_sirup_add = MyArray[i].formula_id;
                addSatu = false;
                console.log("id_formula_sirup_add = " + id_formula_sirup_add);

                $("#boolAdd").val("1");
            } else if (
                MyArray[i].signa.substring(0, 3) == "Add" &&
                $("#boolAdd").val() == "1"
            ) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };

                temp2 += "<tr>";
                temp2 += '<td style="width:15px"></td>';
                temp2 +=
                    '<td style="text-align:left;"><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp2 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp2 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp2 += "<td></td>";
                temp2 += "</tr>";

                // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
                if (
                    !(
                        (
                            (MyArray[a].tipe_formula_id == 1 &&
                                id_formula_sirup_add == 2) || // Cefadroksil capsul dan Cefadroksil syrup
                            (MyArray[a].tipe_formula_id == 3 &&
                                id_formula_sirup_add == 4) || // Brodamox tablet dan Decamox syrup
                            (MyArray[a].tipe_formula_id == 5 &&
                                id_formula_sirup_add == 6) || // Dexycol capsul dan Dionicol syr
                            (MyArray[a].tipe_formula_id == 7 &&
                                id_formula_sirup_add == 8)
                        ) // Cefixime capsul dan Cefixime syr
                    )
                ) {
                    addSatu = true;
                }

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#boolAdd").val("1");
                } else {
                    $("#boolAdd").val("0");
                }
            } else if (MyArray[i].merek_id == $("#merek_id_add_sirup").val()) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };

                temp2 += "<tr>";
                temp2 += '<td style="width:15px"></td>';
                temp2 +=
                    '<td style="border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' +
                    MyArray[i].signa +
                    "</td>";
                temp2 +=
                    '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                temp2 +=
                    "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                    JSON.stringify(ID_TERAPIGroup) +
                    "'>hapus</button></td>";
                temp2 += '<td class="displayNone"></td>';
                temp2 += "</tr>";

                $("#puyer").val("0");
            } else {
                ID_TERAPIGroup = [];
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };

                temp2 += "<tr>";
                temp2 += '<td style="width:15px">R/</td>';
                temp2 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp2 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp2 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp2 += "<td></td>";
                temp2 += "</tr><tr>";
                temp2 += '<td style="width:15px"></td>';
                temp2 +=
                    '<td style="border-bottom:1px solid #000;"> S ' +
                    MyArray[i].signa +
                    "</td>";
                temp2 +=
                    '<td style="border-bottom:1px solid #000;" nowrap>' +
                    MyArray[i].aturan_minum +
                    "</td>";
                temp2 += '<td class="displayNone"></td>';
                temp2 +=
                    "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                    JSON.stringify(ID_TERAPIGroup) +
                    "'>hapus</button></td>";
                temp2 += "</tr>";
            }
        }
        var a = MyArray.length - 1;

        if (
            MyArray[a].merek_id == $("#merek_id_kertas_puyer_biasa").val() ||
            MyArray[a].merek_id == $("#merek_id_kertas_puyer_sablon").val()
        ) {
            console.log(MyArray[a].merek_id + " = 1");

            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp2 += "<tr>";
            temp2 += '<td style="width:15px"></td>';
            temp2 +=
                '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' +
                MyArray[a].jumlah +
                " puyer " +
                MyArray[a].signa +
                "</td>";
            temp2 +=
                '<td style="border-bottom:1px solid #000;" nowrap>' +
                MyArray[a].aturan_minum +
                "</td>";
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone"></td>';
            temp2 += "<td></td>";

            $("#puyer").val("0");
        } else if (MyArray[a].merek_id == $("#merek_id_add_sirup").val()) {
            console.log(MyArray[a].merek_id + " = 2");

            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp2 += "<tr>";
            temp2 += '<td style="width:15px"></td>';
            temp2 +=
                '<td style="border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' +
                MyArray[a].signa +
                "</td>";
            temp2 +=
                '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone"></td>';

            $("#boolAdd").val("0");
        } else if (
            MyArray[a].signa.substring(0, 3) == "Add" &&
            $("#boolAdd").val() == "0"
        ) {
            console.log(MyArray[a].merek_id + " = 3");

            ID_TERAPIGroup = [];

            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp2 += "<tr>";
            temp2 += '<td style="width:15px">R/</td>';
            temp2 +=
                '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp2 += "<td> fls No : " + MyArray[a].jumlah + "</td>";
            temp2 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
            temp2 += "<td></td>";
            temp2 += "</tr>";
            temp2 += "<tr>";
            temp2 += '<td  style="text-align:center;" colspan="3">ADD</td>';
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone"></td>';
            $("#boolAdd").val("1");
        } else if (
            MyArray[a].signa.substring(0, 3) == "Add" &&
            $("#boolAdd").val() == "1"
        ) {
            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            console.log(MyArray[a].merek_id + " = 4");

            temp2 += "<tr>";
            temp2 += '<td style="width:15px"></td>';
            temp2 +=
                '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp2 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";

            // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
            if (
                !(
                    (
                        (MyArray[a].tipe_formula_id == 1 &&
                            id_formula_sirup_add == 2) || // Cefadroksil capsul dan Cefadroksil syrup
                        (MyArray[a].tipe_formula_id == 3 &&
                            id_formula_sirup_add == 4) || // Brodamox tablet dan Decamox syrup
                        (MyArray[a].tipe_formula_id == 5 &&
                            id_formula_sirup_add == 6) || // Dexycol capsul dan Dionicol syr
                        (MyArray[a].tipe_formula_id == 7 &&
                            id_formula_sirup_add == 8)
                    ) // Cefixime capsul dan Cefixime syr
                )
            ) {
                addSatu = true;
            }
        } else if (
            MyArray[a].signa.substring(0, 5) == "Puyer" &&
            $("#puyer").val() == "0"
        ) {
            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };
            console.log(MyArray[a].merek_id + " = 5");

            temp2 += "<tr>";
            temp2 += '<td style="width:15px">R/</td>';
            temp2 +=
                '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp2 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
            $("#puyer").val("1");
        } else if (
            MyArray[a].signa.substring(0, 5) == "Puyer" &&
            $("#puyer").val() == "1"
        ) {
            console.log(MyArray[a].merek_id + " = 6");

            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp2 += "<tr>";
            temp2 += '<td style="width:15px"></td>';
            temp2 +=
                '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp2 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
        } else {
            console.log(MyArray[a].merek_id + " = 7");

            ID_TERAPIGroup = [];

            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp2 += "<tr>";
            temp2 += '<td style="width:15px">R/</td>';
            temp2 +=
                '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp2 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp2 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
            temp2 += "<td></td>";
            temp2 += "</tr><tr>";
            temp2 += '<td style="width:15px"></td>';
            temp2 +=
                '<td style="border-bottom:1px solid #000;"> S ' +
                MyArray[a].signa +
                "</td>";
            temp2 +=
                '<td style="border-bottom:1px solid #000;" nowrap>' +
                MyArray[a].aturan_minum +
                "</td>";
            temp2 +=
                "<td><button class='btn btn-danger btn-sm' onclick='rowdel(this)' type='button' value='" +
                JSON.stringify(ID_TERAPIGroup) +
                "'>hapus</button></td>";
            temp2 += '<td class="displayNone"></td>';
        }
        temp2 += "</tr></tbody></table>";
    } else {
        temp2 = "";
        temp = "";
    }
    //=============================================================
    //=============================================================
    //=============================================================
    $("#puyer").val("0");
    $("#boolAdd").val("0");
    var temp3 = '<table class="RESEP table table-condensed"><tbody>';

    var ID_TERAPIGroup = [];

    //lert(MyArray[0].signa);
    if (MyArray.length > 0) {
        for (var i = 0; i < MyArray.length - 1; i++) {
            if (
                MyArray[i].signa.substring(0, 5) == "Puyer" &&
                $("#puyer").val() == "0"
            ) {
                ID_TERAPIGroup = [];
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp3 += "<tr>";
                temp3 += '<td style="width:15px">R/</td>';
                temp3 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp3 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp3 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp3 += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#puyer").val("1");
                } else {
                    $("#puyer").val("0");
                }
            } else if (
                MyArray[i].signa.substring(0, 5) == "Puyer" &&
                $("#puyer").val() == "1"
            ) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp3 += "<tr>";
                temp3 += '<td style="width:15px"></td>';
                temp3 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp3 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp3 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp3 += "</tr>";

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#puyer").val("1");
                } else {
                    $("#puyer").val("0");
                }
            } else if (
                MyArray[i].merek_id ==
                    $("#merek_id_kertas_puyer_biasa").val() ||
                MyArray[i].merek_id == $("#merek_id_kertas_puyer_sablon").val()
            ) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp3 += "<tr>";
                temp3 += '<td style="width:15px"></td>';
                temp3 +=
                    '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' +
                    MyArray[i].jumlah +
                    " puyer " +
                    MyArray[i].signa +
                    "</td>";
                temp3 +=
                    '<td style="border-bottom:1px solid #000;" nowrap>' +
                    MyArray[i].aturan_minum +
                    "</td>";
                temp3 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp3 += "</tr>";

                $("#puyer").val("0");
            } else if (
                MyArray[i].signa.substring(0, 3) == "Add" &&
                $("#boolAdd").val() == "0"
            ) {
                ID_TERAPIGroup = [];
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };
                temp3 += "<tr>";
                temp3 += '<td style="width:15px">R/</td>';
                temp3 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>";
                temp3 += "<td> fls No : " + MyArray[i].jumlah + "</td>";
                temp3 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp3 += "</tr>";
                temp3 += "<tr>";
                temp3 += '<td  style="text-align:center;" colspan="3">ADD</td>';
                temp3 += '<td class="displayNone"></td>';
                temp3 += "</tr>";

                id_formula_sirup_add = MyArray[i].formula_id;
                addSatu = false;
                console.log("id_formula_sirup_add = " + id_formula_sirup_add);

                $("#boolAdd").val("1");
            } else if (
                MyArray[i].signa.substring(0, 3) == "Add" &&
                $("#boolAdd").val() == "1"
            ) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };

                temp3 += "<tr>";
                temp3 += '<td style="width:15px"></td>';
                temp3 +=
                    '<td style="text-align:left;"><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp3 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp3 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp3 += "</tr>";

                // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
                if (
                    !(
                        (
                            (MyArray[a].formula_id == "150802040" &&
                                id_formula_sirup_add == "150803008") || // Cefadroksil capsul dan Cefadroksil syrup
                            (MyArray[a].formula_id == "150806007" &&
                                id_formula_sirup_add == "150803003") || // Brodamox tablet dan Decamox syrup
                            (MyArray[a].formula_id == "150803047" &&
                                id_formula_sirup_add == "150803006") || // Dexycol capsul dan Dionicol syr
                            (MyArray[a].formula_id == "150806005" &&
                                id_formula_sirup_add == "150921001")
                        ) // Cefixime capsul dan Cefixime syr
                    )
                ) {
                    addSatu = true;
                }

                if (MyArray[i].signa == MyArray[i + 1].signa) {
                    $("#boolAdd").val("1");
                } else {
                    $("#boolAdd").val("0");
                }
            } else if (MyArray[i].merek_id == $("#merek_id_add_sirup").val()) {
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };

                temp3 += "<tr>";
                temp3 += '<td style="width:15px"></td>';
                temp3 +=
                    '<td style="border-bottom:1px solid #000;" >S Masukkan ke dalam sirup ' +
                    MyArray[i].signa +
                    "</td>";
                temp3 +=
                    '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
                temp3 += '<td class="displayNone"></td>';
                temp3 += "</tr>";

                $("#puyer").val("0");
            } else {
                ID_TERAPIGroup = [];
                ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: i };

                temp3 += "<tr>";
                temp3 += '<td style="width:15px">R/</td>';
                temp3 +=
                    '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                    MyArray[i].merek_id +
                    '" onclick="informasi(this); return false; " href="#" nowrap>' +
                    MyArray[i].merek_obat +
                    "</a></t[d>  ";
                temp3 += "<td>   No : " + MyArray[i].jumlah + "</td>";
                temp3 +=
                    '<td class="displayNone">' + MyArray[i].merek_id + "</td>";
                temp3 += "</tr><tr>";
                temp3 += '<td style="width:15px"></td>';
                temp3 +=
                    '<td style="border-bottom:1px solid #000;"> S ' +
                    MyArray[i].signa +
                    "</td>";
                temp3 +=
                    '<td style="border-bottom:1px solid #000;" nowrap>' +
                    MyArray[i].aturan_minum +
                    "</td>";
                temp3 += '<td class="displayNone"></td>';
                temp3 += "</tr>";
            }
        }
        var a = MyArray.length - 1;

        if (
            MyArray[a].merek_id == $("#merek_id_kertas_puyer_biasa").val() ||
            MyArray[a].merek_id == $("#merek_id_kertas_puyer_sablon").val()
        ) {
            console.log(MyArray[a].merek_id + " = 1");

            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp3 += "<tr>";
            temp3 += '<td style="width:15px"></td>';
            temp3 +=
                '<td style="border-bottom:1px solid #000;" nowrap class="merek" >Buat Menjadi ' +
                MyArray[a].jumlah +
                " puyer " +
                MyArray[a].signa +
                "</td>";
            temp3 +=
                '<td style="border-bottom:1px solid #000;" nowrap>' +
                MyArray[a].aturan_minum +
                "</td>";
            temp3 += '<td class="displayNone"></td>';

            $("#puyer").val("0");
        } else if (MyArray[a].merek_id == $("#merek_id_add_sirup").val()) {
            console.log(MyArray[a].merek_id + " = 2");

            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp3 += "<tr>";
            temp3 += '<td style="width:15px"></td>';
            temp3 +=
                '<td style="border-bottom:1px solid #000;">S Masukkan ke dalam sirup ' +
                MyArray[a].signa +
                "</td>";
            temp3 +=
                '<td style="border-bottom:1px solid #000;">Dihabiskan</td>';
            temp3 += '<td class="displayNone"></td>';

            $("#boolAdd").val("0");
        } else if (
            MyArray[a].signa.substring(0, 3) == "Add" &&
            $("#boolAdd").val() == "0"
        ) {
            console.log(MyArray[a].merek_id + " = 3");

            ID_TERAPIGroup = [];

            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp3 += "<tr>";
            temp3 += '<td style="width:15px">R/</td>';
            temp3 +=
                '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp3 += "<td> fls No : " + MyArray[a].jumlah + "</td>";
            temp3 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
            temp3 += "</tr>";
            temp3 += "<tr>";
            temp3 += '<td  style="text-align:center;" colspan="3">ADD</td>';
            temp3 += '<td class="displayNone"></td>';
            $("#boolAdd").val("1");
        } else if (
            MyArray[a].signa.substring(0, 3) == "Add" &&
            $("#boolAdd").val() == "1"
        ) {
            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            console.log(MyArray[a].merek_id + " = 4");

            temp3 += "<tr>";
            temp3 += '<td style="width:15px"></td>';
            temp3 +=
                '<td><a data-target=".bs-example-modal-lg" data-toggle="modal" value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp3 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp3 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";

            // Bila isi dari add sirup ditambahkan penyusunnya saja, maka Add tidak ditambah
            if (
                !(
                    (
                        (MyArray[a].formula_id == "150802040" &&
                            id_formula_sirup_add == "150803008") || // Cefadroksil capsul dan Cefadroksil syrup
                        (MyArray[a].formula_id == "150806007" &&
                            id_formula_sirup_add == "150803003") || // Brodamox tablet dan Decamox syrup
                        (MyArray[a].formula_id == "150803047" &&
                            id_formula_sirup_add == "150803006") || // Dexycol capsul dan Dionicol syr
                        (MyArray[a].formula_id == "150806005" &&
                            id_formula_sirup_add == "150921001")
                    ) // Cefixime capsul dan Cefixime syr
                )
            ) {
                addSatu = true;
            }
        } else if (
            MyArray[a].signa.substring(0, 5) == "Puyer" &&
            $("#puyer").val() == "0"
        ) {
            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };
            console.log(MyArray[a].merek_id + " = 5");

            temp3 += "<tr>";
            temp3 += '<td style="width:15px">R/</td>';
            temp3 +=
                '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp3 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp3 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
            $("#puyer").val("1");
        } else if (
            MyArray[a].signa.substring(0, 5) == "Puyer" &&
            $("#puyer").val() == "1"
        ) {
            console.log(MyArray[a].merek_id + " = 6");

            ID_TERAPIGroup = [];
            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp3 += "<tr>";
            temp3 += '<td style="width:15px"></td>';
            temp3 +=
                '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp3 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp3 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
        } else {
            console.log(MyArray[a].merek_id + " = 7");

            ID_TERAPIGroup = [];

            ID_TERAPIGroup[ID_TERAPIGroup.length] = { id: a };

            temp3 += "<tr>";
            temp3 += '<td style="width:15px">R/</td>';
            temp3 +=
                '<td style="text-align:left;" ><a data-target=".bs-example-modal-lg" data-toggle="modal" data-value="' +
                MyArray[a].merek_id +
                '" onclick="informasi(this); return false; " href="#" nowrap>' +
                MyArray[a].merek_obat +
                "</a></td>";
            temp3 += "<td> No : " + MyArray[a].jumlah + "</td>";
            temp3 += '<td class="displayNone">' + MyArray[a].merek_id + "</td>";
            temp3 += "</tr><tr>";
            temp3 += '<td style="width:15px"></td>';
            temp3 +=
                '<td style="border-bottom:1px solid #000;"> S ' +
                MyArray[a].signa +
                "</td>";
            temp3 +=
                '<td style="border-bottom:1px solid #000;" nowrap>' +
                MyArray[a].aturan_minum +
                "</td>";
            temp3 += '<td class="displayNone"></td>';
        }
        temp3 += "</tr></tbody></table>";
    } else {
        temp2 = "";
        temp3 = "";
        temp = "";
    }
    return [temp, temp2, temp3];
}

function informasi(control){
    var ID = $(control).data('value');


    $.post( base + '/poli/ajax/ajxobat', { 'merek_id' : ID}, function(data) {
        /*optional stuff to do after success */
        data = $.parseJSON(data);
        var MyArray = data.komposisis;
        var temp = '';
        if (MyArray.length > 0) {
            for (var i = 0; i < MyArray.length; i++) {
                temp += '<tr>';
                temp += '<td>' + MyArray[i].komposisi + '</td>';
                temp += '<td>' + MyArray[i].pregnancy_safety_index + '</td>';
                temp += '</tr>';
            }
        } else {
                temp += '<tr>';
                temp += '<td colspan="2" class="text-center">Komposisi Tidak Terdaftar</td>';
                temp += '</tr>';
        }

        $('#nama_obat').text($(control).text());

        $('#kontraindikasi').html(data.kontraindikasi);
        $('#indikasi').html(data.indikasi);
        $('#efek_samping').html(data.efek_samping);
        $('#tabel_komposisi').html(temp);

    });
}

var riwayat = [];

$('#input_riwayat').keydown(function(e) {
    var key = e.keyCode || e.which;
    if (key == 9) {
        $('#input_riwayat').click();
        return false;
    }
});

function inputRiwayatKehamilan(control){
        var riwayat = riwayat_obs();
            if ($('#inputSpontanSC').val() != '') {

                var jenis_kelamin = $('#inputJenisKelamin').val();
                var berat_lahir = $('#inputBeratLahir').val();
                var tahun_lahir = $('#inputTahunLahir').val();
                var lahir_di = $('#inputLahirDi').val();
                var spontan_sc = $('#inputSpontanSC').val();

                riwayat[riwayat.length] = {
                    'jenis_kelamin' : jenis_kelamin,
                    'berat_lahir'   : berat_lahir + ' gr',
                    'tahun_lahir'   : tahun_lahir,
                    'lahir_di'      : lahir_di,
                    'spontan_sc'    : spontan_sc
                } 
                string_obs(riwayat);
               view();
            } else {
                validasi('#inputSpontanSC', 'Hapus Diisi!!');
            }
        }

        function rowDel(control){

            riwayat = riwayat_obs();
            var i = $(control).closest('tr').find('td:first-child');
            i = parseInt(i) - 1 ;

            riwayat.splice(i, 1);
            string_obs(riwayat);
            view();
        }

        function viewNoFocus(){

            var temp = '';
            riwayat = riwayat_obs();
            for (var i = 0; i < riwayat.length; i++) {
                n = parseInt(i) + 1;

                var maks = parseInt(riwayat.length) - 1;

                temp += '<tr>';
                temp += '<td>' + n + '</td>';
                temp += '<td>' + riwayat[i].jenis_kelamin + '</td>';
                temp += '<td>' + riwayat[i].berat_lahir + '</td>';
                temp += '<td>' + riwayat[i].tahun_lahir + '</td>';
                temp += '<td>' + riwayat[i].lahir_di + '</td>';
                temp += '<td>' + riwayat[i].spontan_sc + '</td>';
                if(i == maks){
                    temp += '<td>' + '<button type="button" class="btn btn-danger btn-xs" onclick="rowDel(this);return false;">hapus</button>' + '</td>';
                } else {
                    temp += '<td></td>';
                }
                temp += '</tr>';
            }

            var keyini = parseInt(riwayat.length) + 1

            temp            +='<tr>';
            temp            +='<td>' + keyini + '</td>';
            temp            +='<td>ini<td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='<td></td>';
            temp            +='</tr>';

            $('.inp').val('');
            $('#table_riwayat_kehamilan').html(temp);

            var string = JSON.stringify(riwayat);
            $('#riwayat_kehamilan').val(string);

        }
         function view(){

            viewNoFocus();
            $('#inputJenisKelamin').focus();    


        }

        function riwayat_obs(){
            riwayat = $('#riwayat_kehamilan').val();
            if (riwayat == '') {
                riwayat = '[]';
            }
            return JSON.parse(riwayat);
        }

        function string_obs(riwayat){
            riwayat = JSON.stringify(riwayat);
            $('#riwayat_kehamilan').val(riwayat);
        }



function uk(umur_kehamilan, hari) {

	$("#" + hari).datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
	}).on("changeDate", function(e) {
		uk_exec(umur_kehamilan, hari);
	});

	$('#' + umur_kehamilan).attr('readonly', 'readonly');
}

function uk_exec(umur_kehamilan, hari) {
	if ($('#' + hari).val() != '') {
	    var HPHT =  $('#' + hari).val();

	    $.post(base +"/anc/uk" , {'hpht': HPHT }, function(data) {
	        data = $.trim(data);
	        $('#' + umur_kehamilan).val(data); 
	    });

	} else {
	    $('#' + umur_kehamilan).val(''); 
	}
}