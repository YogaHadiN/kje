refreshResumeKeadaanGigi();
var focus_evolusi_gigi;
function focusEvolusiGigi(control) {
    focus_evolusi_gigi = $(control).val();
}
$("#odontogramEditor").on("shown.bs.modal", function (e) {
    $("#odontogramEditorTab a:first").tab("show");
});

$("#odontogramEditor").on("hidden.bs.modal", function (e) {
    $("#odontogramEditorTab a:first").tab("show");
});
$("#tabButtonTindakanGigi").on("shown.bs.tab", function (e) {
    var evolusi_gigi = $("#odontogramEditor")
        .find(".modal-body")
        .find(".evolusi_gigi")
        .val();
    if (evolusi_gigi == null || evolusi_gigi == "") {
        $("#odontogramEditorTab a:first").tab("show");
        validasi1(
            $("#odontogramEditor").find(".modal-body").find(".evolusi_gigi"),
            "Evolusi gigi harus diisi terlebih dahulu"
        );
    }
});
function refreshResumeKeadaanGigi() {
    $.get(
        base + "/polis/ajax/resume/keadaan_gigi/awal/" + $("#pasien_id").val(),
        {
            pasien_id: $("#pasien_id").val(),
        },
        function (data, textStatus, jqXHR) {
            viewDataResumeKeadaanGigi(data);
        }
    );
}
function bukaOdontogram(control) {
    var pasien_id = $("#pasien_id").val();
    var nama_taksonomi_gigi = $(control)
        .closest("tr")
        .find(".nama_taksonomi_gigi")
        .html();
    var taksonomi_gigi_id = $(control)
        .closest("tr")
        .find(".taksonomi_gigi_id")
        .html();

    $("#odontogramEditor")
        .find(".modal-body")
        .find(".taksonomi_gigi_id")
        .val(taksonomi_gigi_id);
    $("#odontogramEditor")
        .find(".modal-body")
        .find(".nama_taksonomi_gigi")
        .val(nama_taksonomi_gigi);
    viewKeadaanGigi();
    $("#odontogramEditor").modal("show");
}
function submitKeadaanGigi(control) {
    var odontogram_id = $("#odontogramEditor")
        .find(".modal-body")
        .find(".odontogram_id")
        .val();
    var permukaan_gigi_id = $(control)
        .closest("tr")
        .find(".permukaan_gigi_id")
        .val();
    var odontogram_abbreviation_id = $(control)
        .closest("tr")
        .find(".odontogram_abbreviation_id")
        .val();

    var evolusi_gigi = $("#odontogramEditor")
        .find(".modal-body")
        .find(".evolusi_gigi")
        .val();
    if (
        odontogram_id != "" &&
        odontogram_id != null &&
        permukaan_gigi_id != "" &&
        permukaan_gigi_id != null &&
        odontogram_abbreviation_id != "" &&
        odontogram_abbreviation_id != null &&
        evolusi_gigi != "" &&
        evolusi_gigi != null
    ) {
        $.post(
            base + "/polis/ajax/submit/keadaan_gigi",
            {
                odontogram_id: odontogram_id,
                permukaan_gigi_id: permukaan_gigi_id,
                odontogram_abbreviation_id: odontogram_abbreviation_id,
            },
            function (data, textStatus, jqXHR) {
                viewKeadaanGigi();
            }
        );
    } else {
        if (permukaan_gigi_id == "" || permukaan_gigi_id == null) {
            validasi1(
                $(control).closest("tr").find(".permukaan_gigi_id"),
                "Permukaan Gigi Harus Diisi"
            );
        }
        if (
            odontogram_abbreviation_id == "" ||
            odontogram_abbreviation_id == null
        ) {
            validasi1(
                $(control).closest("tr").find(".odontogram_abbreviation_id"),
                "Odontogram harus diisi"
            );
        }
        if (!evolusi_gigi) {
            validasi1(
                $("#odontogramEditor")
                    .find(".modal-body")
                    .find(".evolusi_gigi"),
                "Maturasi gigi harus diisi"
            );
        }
    }
}
function viewKeadaanGigi() {
    var pasien_id = $("#pasien_id").val();

    var nama_taksonomi_gigi = $("#odontogramEditor")
        .find(".modal-body")
        .find(".nama_taksonomi_gigi")
        .val();
    var taksonomi_gigi_id = $("#odontogramEditor")
        .find(".modal-body")
        .find(".taksonomi_gigi_id")
        .val();

    $.get(
        base + "/pasiens/ajax/odontogram",
        {
            pasien_id: pasien_id,
            taksonomi_gigi_id: taksonomi_gigi_id,
        },
        function (data, textStatus, jqXHR) {
            var odontogram = data.odontogram;
            $("#odontogramEditor")
                .find(".modal-body")
                .find(".odontogram_id")
                .val(odontogram.id);
            var keadaan_gigi = odontogram.keadaan_gigi;
            var temp = "";
            $("#odontogramEditor")
                .find(".modal-title")
                .html("Taksonomi Gigi : " + nama_taksonomi_gigi);
            var matur = odontogram.matur;
            if (
                odontogram.taksonomi_gigi.taksonomi_gigi_anak == "" ||
                odontogram.taksonomi_gigi.taksonomi_gigi_anak == null
            ) {
                if (
                    !$("#odontogramEditor")
                        .find(".modal-body")
                        .find(".evolusi_gigi")
                        .closest(".form-group")
                        .hasClass("hide")
                ) {
                    $("#odontogramEditor")
                        .find(".modal-body")
                        .find(".evolusi_gigi")
                        .closest(".form-group")
                        .addClass("hide");
                }

                $("#odontogram_container")
                    .closest("table")
                    .find(".taksonomi_gigi")
                    .each(function () {
                        if (!$(this).hasClass("hide")) {
                            $(this).addClass("hide");
                        }
                    });

                $("#td_permukaan_gigi_id").attr("colspan", "1");

                matur = 1;
            } else {
                if (
                    $("#odontogramEditor")
                        .find(".modal-body")
                        .find(".evolusi_gigi")
                        .closest(".form-group")
                        .hasClass("hide")
                ) {
                    $("#odontogramEditor")
                        .find(".modal-body")
                        .find(".evolusi_gigi")
                        .closest(".form-group")
                        .removeClass("hide");
                }
                $("#odontogram_container")
                    .closest("table")
                    .find(".taksonomi_gigi")
                    .each(function () {
                        if ($(this).hasClass("hide")) {
                            $(this).removeClass("hide");
                        }
                    });
                $("#td_permukaan_gigi_id").attr("colspan", "2");
            }

            $("#odontogramEditor")
                .find(".modal-body")
                .find(".evolusi_gigi")
                .val(matur);

            for (let i = 0, len = keadaan_gigi.length; i < len; i++) {
                temp += "<tr>";
                temp +=
                    '<td class="hide keadaan_gigi_id">' +
                    keadaan_gigi[i].id +
                    "</td>";
                temp += '<td class="hide pasien_id">' + pasien_id + "</td>";
                temp +=
                    '<td class="hide permukaan_gigi_id">' +
                    keadaan_gigi[i].permukaan_gigi_id +
                    "</td>";
                temp +=
                    '<td class="hide taksonomi_gigi_id">' +
                    taksonomi_gigi_id +
                    "</td>";
                if (
                    data.taksonomi_gigi.taksonomi_gigi_anak != "" &&
                    data.taksonomi_gigi.taksonomi_gigi_anak != null
                ) {
                    temp += '<td class="taksonomi_gigi">';
                } else {
                    temp += '<td class="taksonomi_gigi hide">';
                }
                temp +=
                    keadaan_gigi[i].matur == "0" &&
                    keadaan_gigi[i].odontogram.taksonomi_gigi
                        .taksonomi_gigi_anak != "" &&
                    keadaan_gigi[i].odontogram.taksonomi_gigi
                        .taksonomi_gigi_anak != null
                        ? keadaan_gigi[i].odontogram.taksonomi_gigi
                              .taksonomi_gigi_anak
                        : keadaan_gigi[i].odontogram.taksonomi_gigi
                              .taksonomi_gigi;
                temp += "</td>";
                temp +=
                    "<td>" + keadaan_gigi[i].permukaan_gigi.extension + "</td>";
                temp +=
                    "<td>" +
                    keadaan_gigi[i].odontogram_abbreviation.extension +
                    "</td>";
                temp += '<td style="width: 1px; nowrap;">';
                temp +=
                    '<button class="btn btn-danger btn-sm" onclick="removeKeadaanGigi(this);return false;">';
                temp +=
                    '<span class="glyphicon glyphicon-remove" aria-hidden="true">';
                temp += "</span>";
                temp += "</button>";
                temp += "</td>";
                temp += "</tr>";
            }
            $("#odontogramEditor")
                .find(".modal-body")
                .find(".permukaan_gigi_id")
                .val(1);

            $("#odontogramEditor")
                .find(".modal-body")
                .find(".odontogram_abbreviation_id")
                .val(null)
                .selectpicker("refresh");

            $("#odontogram_container").html(temp);

            var temp = "";
            var diagnosa_dan_tindakan = data.diagnosa_dan_tindakan;

            for (let i = 0, len = diagnosa_dan_tindakan.length; i < len; i++) {
                temp += "<tr>";
                temp +=
                    "<td  rowspan='" +
                    diagnosa_dan_tindakan[i].tindakan.length +
                    "' class='tanggal fit'>";
                temp += diagnosa_dan_tindakan[i].tanggal;
                temp += "</td>";
                for (
                    let x = 0, len = diagnosa_dan_tindakan[i].tindakan.length;
                    x < len;
                    x++
                ) {
                    if (x > 0) {
                        temp += "<tr>";
                    }
                    temp += "<td class='fit'>";
                    temp += diagnosa_dan_tindakan[i].tindakan[x].jenis_tarif;
                    temp += "</td>";
                    temp += "<td class='fit'>";
                    temp += diagnosa_dan_tindakan[i].tindakan[x].permukaan_gigi;
                    temp += "</td>";
                    temp += "<td>";
                    temp +=
                        diagnosa_dan_tindakan[i].tindakan[x]
                            .keterangan_pemeriksaan != null
                            ? diagnosa_dan_tindakan[i].tindakan[x]
                                  .keterangan_pemeriksaan
                            : "";
                    temp += "</td>";
                    if (x > 0) {
                        temp += "</tr>";
                    }
                }
            }
            $("#diagnosa_dan_tindakan_gigi_container").html(temp);

            var tindakan_gigi_template = tindakanGigiArray();
            viewTindakanGigiOnly(tindakan_gigi_template);
            viewDataResumeKeadaanGigi(data.keadaanGigi);
        }
    );
}
function updateEvolusiGigi(control) {
    var evolusi_gigi = $(control).val();
    if (evolusi_gigi) {
        var odontogram_id = $("#odontogramEditor")
            .find(".modal-body")
            .find(".odontogram_id")
            .val();
        $.post(
            base + "/polis/ajax/update/ovolusi_gigi",
            {
                odontogram_id: odontogram_id,
                evolusi_gigi: evolusi_gigi,
            },
            function (data, textStatus, jqXHR) {
                viewDataResumeKeadaanGigi(data);
            }
        );
        focus_evolusi_gigi = $(control).val();
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "evolusi gigi harus terisi",
        });
        $(control).val(focus_evolusi_gigi);
    }
}
function removeKeadaanGigi(control) {
    Swal.fire({
        title: "Anda yakin mau menghapus odontogram ini",
        showCancelButton: true,
        confirmButtonText: "Yakin",
        denyButtonText: `Batalkan`,
    }).then((result) => {
        var keadaan_gigi_id = $(control)
            .closest("tr")
            .find(".keadaan_gigi_id")
            .html();
        $.post(
            base + "/polis/ajax/remove/keadaan_gigi",
            {
                keadaan_gigi_id: keadaan_gigi_id,
            },
            function (data, textStatus, jqXHR) {
                viewKeadaanGigi();
            }
        );
    });
}
function submitTindakanGigi(control) {
    var jenis_tarif_id = $(control)
        .closest("tr")
        .find(".tindakan_gigi_id")
        .val();
    var asuransi_id = $("#asuransi_id").val();
    $.get(
        base + "/polis/ajax/get/biaya",
        {
            jenis_tarif_id: jenis_tarif_id,
            asuransi_id: asuransi_id,
        },
        function (data, textStatus, jqXHR) {
            var taksonomi_gigi_id = $("#odontogramEditor")
                .find(".modal-body")
                .find(".taksonomi_gigi_id")
                .val();
            var jenis_tarif = $(control)
                .closest("tr")
                .find(".tindakan_gigi_id option:selected")
                .text();
            var permukaan_gigi_id = $(control)
                .closest("tr")
                .find(".permukaan_gigi_id")
                .val();
            var permukaan_gigi = $(control)
                .closest("tr")
                .find(".permukaan_gigi_id option:selected")
                .text();
            var keterangan_tindakan_gigi = $(control)
                .closest("tr")
                .find(".keterangan_tindakan_gigi")
                .val();
            var tindakan_gigi_template = tindakanGigiArray();
            tindakan_gigi_template[taksonomi_gigi_id] =
                tindakan_gigi_template[taksonomi_gigi_id] != null
                    ? tindakan_gigi_template[taksonomi_gigi_id]
                    : [];

            if (
                jenis_tarif_id !== null &&
                !jenis_tarif_id == "" &&
                permukaan_gigi_id !== null &&
                !permukaan_gigi_id == ""
            ) {
                var key = inputTindakan(
                    jenis_tarif_id,
                    jenis_tarif,
                    data,
                    keterangan_tindakan_gigi
                );

                key = parseInt(key) + 2;
                tindakan_gigi_template[taksonomi_gigi_id].push({
                    transaksi_periksa_key: parseInt(key),
                    jenis_tarif_id: jenis_tarif_id,
                    jenis_tarif: jenis_tarif,
                    permukaan_gigi: permukaan_gigi,
                    permukaan_gigi_id: permukaan_gigi_id,
                    keterangan_tindakan_gigi: keterangan_tindakan_gigi,
                });
                viewTindakanGigi(tindakan_gigi_template);
                viewKeadaanGigi();
            } else {
                if (jenis_tarif_id == null || jenis_tarif_id == "") {
                    validasi1(
                        $(control).closest("tr").find(".tindakan_gigi_id"),
                        "Harus diisi"
                    );
                }

                if (permukaan_gigi_id == null || permukaan_gigi_id == "") {
                    validasi1(
                        $(control).closest("tr").find(".permukaan_gigi_id"),
                        "Harus diisi"
                    );
                }
            }
        }
    );
}
function removeTindakanGigi(control) {
    var i = $(control).closest("tr").find(".i").html();
    var taksonomi_gigi_id = $("#odontogramEditor")
        .find(".modal-body")
        .find(".taksonomi_gigi_id")
        .val();
    var tindakan_gigi_template = tindakanGigiArray();
    var transaksi_periksa_key =
        tindakan_gigi_template[taksonomi_gigi_id][i].transaksi_periksa_key;

    tindakan_gigi_template[taksonomi_gigi_id].splice(i, 1);
    viewTindakanGigi(tindakan_gigi_template);
    viewKeadaanGigi();
    deleteTindakan(parseInt(transaksi_periksa_key) - 2);
}
function tindakanGigiArray() {
    var tindakan_gigi_template = $("#tindakan_gigi").val();
    if (tindakan_gigi_template == "") {
        tindakan_gigi_template = "[]";
    }
    return JSON.parse(tindakan_gigi_template);
}
function viewTindakanGigiOnly(tindakan_gigi_template) {
    var taksonomi_gigi_id = $("#odontogramEditor")
        .find(".modal-body")
        .find(".taksonomi_gigi_id")
        .val();
    $("#tindakan_gigi").val(JSON.stringify(tindakan_gigi_template));
    var temp = "";
    var tindakan_gigi =
        tindakan_gigi_template[taksonomi_gigi_id] != null
            ? tindakan_gigi_template[taksonomi_gigi_id]
            : [];
    for (let i = 0, len = tindakan_gigi.length; i < len; i++) {
        temp += "<tr>";
        temp += "<td class='i hide'>";
        temp += i;
        temp += "</td>";
        temp += "<td>";
        temp += tindakan_gigi[i].jenis_tarif;
        temp += "</td>";
        temp += "<td>";
        temp += tindakan_gigi[i].permukaan_gigi;
        temp += "</td>";
        temp += "<td>";
        temp += tindakan_gigi[i].keterangan_tindakan_gigi;
        temp += "</td>";
        temp += '<td style="width: 1px; nowrap;">';
        temp +=
            '<button class="btn btn-danger btn-sm" onclick="removeTindakanGigi(this);return false;">';
        temp += '<span class="glyphicon glyphicon-remove" aria-hidden="true">';
        temp += "</span>";
        temp += "</tr>";
    }
    $("#odontogramEditor .tindakan_gigi_container").html(temp);

    $("#odontogramEditor")
        .find(".modal-body")
        .find(".tindakan_gigi_id")
        .empty()
        .trigger("change");

    $("#odontogramEditor")
        .find(".modal-body")
        .find(".permukaan_gigi_id")
        .val("");

    $("#odontogramEditor")
        .find(".modal-body")
        .find(".keterangan_tindakan_gigi")
        .val("");
}
function viewTindakanGigi(tindakan_gigi_template) {
    viewTindakanGigiOnly(tindakan_gigi_template);
    $("#odontogramEditor")
        .find(".modal-body")
        .find(".tindakan_gigi_id")
        .select2("focus");
    $("#odontogramEditor")
        .find(".modal-body")
        .find(".tindakan_gigi_id")
        .select2("open");
}

$(document).ready(function () {
    $("#odontogramEditor")
        .find(".modal-body")
        .find(".tindakan_gigi_id")
        .select2(
            ajax_search_on_modal(
                "polis/ajax/search/tindakan",
                "Pilih tindakan",
                $("#odontogramEditor .modal-content")
            )
        );
    // $("#selectTindakan")
    //     .select2(
    //         ajax_search_on_modal(
    //             "polis/ajax/search/jenis_tarif/non_gigi",
    //             "Pilih tindakan",
    //             $("#modalTindakan .modal-content")
    //         )
    //     )
    //     .on("change", function (e) {
    //         selectChange(this);
    //         return false;
    //     });
});

function rowKeadaanGigi(keadaanGigi) {
    var tindakan_gigi_template = tindakanGigiArray();
    var temp = "";
    temp += "<tr>";
    temp += "<td class='hide taksonomi_gigi_id'>";
    temp += keadaanGigi.taksonomi_gigi_id;
    temp += "</td>";
    temp += "<td class='fit'>";
    temp += keadaanGigi.taksonomi_gigi;
    temp += "</td>";
    temp += "<td>";
    temp +=
        keadaanGigi.resume_keadaan_gigi != ""
            ? keadaanGigi.resume_keadaan_gigi
            : "";
    if (keadaanGigi.jumlah_tindakan_gigi) {
        temp += '<span class="float-right badge badge-success">';
        temp += "tindakan";
        temp += "</span>";
    }

    if (
        tindakan_gigi_template[keadaanGigi.taksonomi_gigi_id] != null &&
        tindakan_gigi_template[keadaanGigi.taksonomi_gigi_id].length > 0
    ) {
        temp += '<span class="float-right badge badge-primary">';
        temp += "new";
        temp += "</span>";
    }
    temp += "</td>";
    temp += "<td style='width: 1%; nowrap'>";
    temp +=
        "<button onclick='bukaOdontogram(this);return false;' class='btn btn-info btn-xs' type='button'>";
    temp += "<span class='glyphicon glyphicon-pencil' aria-hidden='true'>";
    temp += "</span>";
    temp += "</button>";
    temp += "</td>";
    temp += "</tr>";
    return temp;
}
function viewDataResumeKeadaanGigi(keadaanGigi) {
    var temp_1 = "";
    var temp_2 = "";
    var temp_3 = "";
    var temp_4 = "";

    for (let i = 0, len = keadaanGigi.length; i < len; i++) {
        if (
            keadaanGigi[i]["taksonomi_gigi_id"] >= 1 &&
            keadaanGigi[i]["taksonomi_gigi_id"] <= 8
        ) {
            temp_1 += rowKeadaanGigi(keadaanGigi[i]);
        }
        if (
            keadaanGigi[i]["taksonomi_gigi_id"] >= 9 &&
            keadaanGigi[i]["taksonomi_gigi_id"] <= 16
        ) {
            temp_2 += rowKeadaanGigi(keadaanGigi[i]);
        }
        if (
            keadaanGigi[i]["taksonomi_gigi_id"] >= 17 &&
            keadaanGigi[i]["taksonomi_gigi_id"] <= 24
        ) {
            temp_3 += rowKeadaanGigi(keadaanGigi[i]);
        }
        if (
            keadaanGigi[i]["taksonomi_gigi_id"] >= 25 &&
            keadaanGigi[i]["taksonomi_gigi_id"] <= 32
        ) {
            temp_4 += rowKeadaanGigi(keadaanGigi[i]);
        }
    }

    $(".keadaan_gigi_taksonomi_id_1").html(temp_1);
    $(".keadaan_gigi_taksonomi_id_2").html(temp_2);
    $(".keadaan_gigi_taksonomi_id_3").html(temp_3);
    $(".keadaan_gigi_taksonomi_id_4").html(temp_4);
}
