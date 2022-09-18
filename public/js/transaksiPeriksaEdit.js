var coa_id = null;
var text = "";
var selected_coa_id = "";
temp = parseTemp();
viewJurnals();
render(temp);

viewTransaksiPeriksa();
function dummySubmit(control) {
    var jurnals = getJurnalObject();
    var debit = 0;
    var kredit = 0;
    for (let i = 0, len = jurnals.length; i < len; i++) {
        if (jurnals[i]["debit"] == 1) {
            debit += jurnals[i]["nilai"];
        } else {
            kredit += jurnals[i]["nilai"];
        }
    }
    var jurnal_seimbang = debit == kredit;

    var transaksis = getTransaksiArray();
    var total_biaya = 0;
    for (let i = 0, len = transaksis.length; i < len; i++) {
        total_biaya += transaksis[i]["biaya"];
    }
    var tunai = cleanUang($("#totalTransaksiTunai").val());
    var piutang = cleanUang($("#totalTransaksiPiutang").val());
    var transaksi_sama = total_biaya == tunai + piutang;

    if (!jurnal_seimbang) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text:
                "Jurnal Umum debit dan kredit tidak seimbang. Total debit = " +
                uang(debit) +
                " dan total kredit = " +
                uang(kredit),
        });
    } else if (!transaksi_sama) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text:
                "Jumlah antara transaksi tunai/piutang dan transaksi pemeriksaan tidak sama. Total tunai dan piutang = " +
                uang(tunai + piutang) +
                ". Sedangkan total pemeriksaan transaksi = " +
                uang(total_biaya),
        });
    } else {
        $("#submit").click();
    }
}
function nilaiTransaksi(control) {
    var nilai = cleanUang($(control).val());
    var key = $(control).attr("title");
    var jurnals = $("#jurnals").val();
    jurnals = JSON.parse(jurnals);
    jurnals[key]["biaya"] = nilai;
    jurnals = JSON.stringify(jurnals);
    $("#jurnlas").val(jurnals);
    $("#debit_total").html(hitung().debit);
    $("#kredit_total").html(hitung().kredit);
}

function refreshTunaiPiutang(control) {
    var asuransi_id = $("#asuransi_id").val();
    $.get(
        base + "/periksas/edit/transaksiPeriksa/process/refreshTunaiPiutang",
        { asuransi_id: asuransi_id },
        function (data, textStatus, jqXHR) {
            if (data["tipe_asuransi_id"] == 1) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Data tidak bisa diubah",
                });
            } else {
                var temp = parseTemp();
                var total_transaksi = 0;
                var transaksis = $("#transaksis").val();
                transaksis = JSON.parse(transaksis);
                console.log("transaksis", transaksis);
                for (let i = 0, len = transaksis.length; i < len; i++) {
                    total_transaksi += parseInt(transaksis[i].biaya);
                }
                var tunai = cleanUang($("#totalTransaksiTunai").val());
                var piutang = cleanUang($("#totalTransaksiPiutang").val());
                if (tunai > total_transaksi) {
                    console.log("triggered 1");
                    $("#totalTransaksiTunai").val(uang(total_transaksi));
                    piutang = 0;
                    $("#totalTransaksiPiutang").val(uang(piutang));
                } else if (tunai == "") {
                    console.log("triggered 2");
                    tunai = 0;
                    piutang = total_transaksi;
                    $("#totalTransaksiTunai").val(uang(tunai));
                    $("#totalTransaksiPiutang").val(uang(piutang));
                } else {
                    console.log("triggered 3");
                    piutang = total_transaksi - tunai;
                    $("#totalTransaksiPiutang").val(uang(piutang));
                }

                var jurnals = getJurnalObject();
                if (tunai > 0) {
                    var jurnal_tunai_ditemukan = false;
                    for (let i = 0, len = jurnals.length; i < len; i++) {
                        if (
                            jurnals[i]["coa"]["kode_coa"] ==
                            data["kode_coa_asuransi"]
                        ) {
                            jurnals[i]["nilai"] = piutang;
                        }

                        if (jurnals[i]["coa"]["kode_coa"] == 110000) {
                            jurnals[i]["nilai"] = tunai;
                            jurnal_tunai_ditemukan = true;
                        }
                    }
                    if (!jurnal_tunai_ditemukan) {
                        var silahkanTambahJurnal = true;
                        for (let i = 0, len = jurnals.length; i < len; i++) {
                            if (
                                silahkanTambahJurnal &&
                                jurnals[i]["debit"] == 0
                            ) {
                                var jurnalBaru = {
                                    jurnalable_id: null,
                                    debit: 1,
                                    nilai: tunai,
                                    coa_id: 110000,
                                    created_at: null,
                                    updated_at: null,
                                    jurnalable_type: "App\\Models\\Periksa",
                                    coa: data["coa_tunai"],
                                };
                                jurnals.splice(i - 1, 0, jurnalBaru);
                                silahkanTambahJurnal = false;
                            }
                        }
                    }
                }
                stringifyJurnal(jurnals);
                viewJurnals();
                var periksa = getPeriksaObject();
                periksa["tunai"] = cleanUang($("#totalTransaksiTunai").val());
                periksa["piutang"] = cleanUang(
                    $("#totalTransaksiPiutang").val()
                );
                stringifyPeriksa(periksa);
            }
        }
    );
}
function coaChange(control) {
    var key = parseInt($(control).closest("tr").find(".key").html());
    var coa_id = $(control).val();
    var data = $("#jurnals").val();
    data = JSON.parse(data);
    console.log("data", data, "key", key, "coa_id", coa_id);
    data[key]["coa_id"] = coa_id;
    data = JSON.stringify(data);
    $("#jurnals").val(data);
}

function nilaiKeyUp(control) {
    var key = parseInt($(control).closest("tr").find(".key").html());
    var nilai = cleanUang($(control).val());
    var data = $("#jurnals").val();
    data = JSON.parse(data);
    data[key]["nilai"] = parseInt(nilai);
    data = JSON.stringify(data);
    $("#jurnals").val(data);
    var htg = hitung();
    callValue(htg);
}
function transaksiPeriksa(control) {
    var nilai = $(control).closest("tr").find(".biaya").val();
    console.log("nilai", nilai);
    nilai = cleanUang(nilai);
    console.log("nilai", nilai);
    var keterangan_pemeriksaan = $(control)
        .closest("tr")
        .find(".keterangan_pemeriksaan")
        .val();
    var key = $(control).closest("tr").find(".k").html();

    var transaksis = getTransaksiArray();
    transaksis[key].biaya = nilai;
    transaksis[key].keterangan_pemeriksaan = keterangan_pemeriksaan;
    var total_biaya = 0;
    for (let i = 0, len = transaksis.length; i < len; i++) {
        console.log("transaksis", transaksis);
        total_biaya += parseInt(transaksis[i]["biaya"]);
    }
    stringifyTransaksi(transaksis);
    var coa_id = $(control).closest("tr").find(".coa_id").html();

    var jurnals = getJurnalObject();
    var total_diganti = true;
    for (let i = 0, len = jurnals.length; i < len; i++) {
        if (jurnals[i]["coa_id"] == coa_id) {
            jurnals[i]["nilai"] = nilai;
        }
        if (
            jurnals[i]["coa"]["kode_coa"].substring(0, 2) == "11" &&
            total_diganti == true
        ) {
            jurnals[i]["nilai"] = total_biaya;
            total_diganti = false;
        }
    }
    stringifyJurnal(jurnals);
    refreshTunaiPiutang();
    $("#biaya_total").html(hitung().biaya);
    var htg = hitung();
    callValue(htg);
}
function hitung() {
    var jurnals = $("#jurnals").val();
    jurnals = JSON.parse(jurnals);
    var temp = $("#temp").val();
    temp = JSON.parse(temp);
    var transaksis = $("#transaksis").val();
    transaksis = JSON.parse(transaksis);
    var periksa = $("#periksa").val();
    periksa = JSON.parse(periksa);

    var debit = 0;
    var kredit = 0;
    var total_harta_masuk = 0;
    for (var i = 0; i < jurnals.length; i++) {
        if (jurnals[i].debit == "1") {
            debit += parseInt(jurnals[i].nilai);
        } else {
            kredit += parseInt(jurnals[i].nilai);
        }
        if (
            jurnals[i].coa.kode_coa.substring(0, 2) == "11" &&
            jurnals[i].debit == "1"
        ) {
            total_harta_masuk += parseInt(jurnals[i].nilai);
        }
    }
    for (var i = 0; i < temp.length; i++) {
        if (temp[i].debit == "1") {
            debit += parseInt(temp[i].nilai);
        } else {
            kredit += parseInt(temp[i].nilai);
        }
        if (
            temp[i].coa.kode_coa.substring(0, 2) == "11" &&
            temp[i].debit == "1"
        ) {
            total_harta_masuk += parseInt(temp[i].nilai);
        }
    }
    var biaya = 0;
    for (var i = 0; i < transaksis.length; i++) {
        biaya += parseInt(transaksis[i].biaya);
    }
    var total_periksa = parseInt(periksa.tunai) + parseInt(periksa.piutang);

    return {
        kredit: kredit,
        debit: debit,
        biaya: biaya,
        total_periksa: total_periksa,
        total_harta_masuk: total_harta_masuk,
    };
}
function stringifyJurnal(data) {
    data = JSON.stringify(data);
    $("#jurnals").val(data);
}
function delJurnal(control) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            var jurnals = getJurnalObject();
            var i = $(control).closest("tr").find(".key").html();
            i = $.trim(i);
            jurnals.splice(i, 1);
            stringifyJurnal(jurnals);

            //hapus jurnal di transaksi jurnal dan update total biaya

            viewJurnals();
            var htg = hitung();
            callValue(htg);
            var rows = $("#table_template_jurnal tbody tr").length;
            for (var i = 0, len = rows; i < len; i++) {
                $(
                    "#table_template_jurnal tbody tr:nth-child(" +
                        parseInt(i + 1) +
                        ")"
                )
                    .find(".key")
                    .html(i);
            }
        }
    });
}
function callValue(htg) {
    // console.log('===============================================================');
    // console.log('kredit');
    // console.log(htg.kredit);
    // console.log('debit');
    // console.log(htg.debit);
    // console.log('biaya');
    // console.log(htg.biaya);
    // console.log('total_periksa');
    // console.log(htg.total_periksa);
    // console.log('total_harta_masuk');
    // console.log(htg.total_harta_masuk);
    // console.log('===============================================================');
}
function changeAsuransi(control) {
    var asuransi_id = $(control).val();
    var prev_asuransi_coa_id = $("#asuransi_coa_id").html();
    var periksa = $("#periksa").val();
    periksa = JSON.parse(periksa);
    periksa["asuransi_id"] = asuransi_id;
    periksa = JSON.stringify(periksa);
    $("#periksa").val(periksa);
    $.get(
        base + "/asuransis/get/coa_id",
        { asuransi_id: asuransi_id },
        function (data, textStatus, jqXHR) {
            var jurnals = getJurnalObject();
            for (let i = 0, len = jurnals.length; i < len; i++) {
                if (jurnals[i].coa.kode_coa.substring(0, 3) == "111") {
                    jurnals[i].coa_id = data.coa_id;
                    jurnals[i].coa = data.coa;
                    break;
                }
            }
            stringifyJurnal(jurnals);
            viewJurnals();
        }
    );
}
function updatePeriksa(nilai, tipe) {
    var periksa = $("#periksa").val();
    periksa = JSON.parse(periksa);
    periksa[tipe] = nilai;
    periksa = JSON.stringify(periksa);
    $("#periksa").val(periksa);
}
function getKey(temp) {
    var key = "";
    for (let i = 0, len = temp.length; i < len; i++) {
        if (temp[i].coa.kode_coa.substring(0, 3) == "110") {
            key = i;
            break;
        }
    }
    return key;
}
function viewTransaksiPeriksa() {
    var transaksiPeriksaArray = getTransaksiArray();

    var temp = "";
    for (let i = 0, len = transaksiPeriksaArray.length; i < len; i++) {
        temp += "<tr>";
        temp += "<td class='k hide'>";
        temp += i;
        temp += "</td>";
        temp +=
            "<td class='coa_id hide'>" +
            transaksiPeriksaArray[i]["jenis_tarif"]["coa_id"] +
            "</td>";
        temp +=
            "<td class='jenis_tarif'>" +
            transaksiPeriksaArray[i]["jenis_tarif"]["jenis_tarif"] +
            "</td>";
        temp +=
            "<td>" +
            '<input class="form-control uangInputTransaksiPeriksa text-right biaya" id="tunai" onkeyup="transaksiPeriksa(this);return false;" name="tunai" type="text" value="' +
            transaksiPeriksaArray[i]["biaya"] +
            '" autocomplete="off">' +
            "</td>";
        var keterangan_pemeriksaan =
            transaksiPeriksaArray[i]["keterangan_pemeriksaan"] !== null
                ? transaksiPeriksaArray[i]["keterangan_pemeriksaan"]
                : "";
        temp +=
            "<td>" +
            '<input class="form-control text-right keterangan_pemeriksaan" id="" onkeyup="transaksiPeriksa(this);return false;" name="tunai" type="text" value="' +
            keterangan_pemeriksaan +
            '" autocomplete="off">' +
            "</td>";
        temp += "<td>";
        temp +=
            '<button class="btn btn-xs btn-danger" onclick="hapusTransaksi(this);return false;">hapus</button>';
        temp += "</td>";
        temp += "</tr>";
    }

    $("#container_transaksi_periksa").html(temp);
    $(".uangInputTransaksiPeriksa").autoNumeric("init", {
        aSep: ".",
        aDec: ",",
        aSign: "Rp. ",
        vMin: "-9999999999999.99",
        mDec: 0,
    });
}
function hapusTransaksi(control) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            var coa_id = $(control).closest("tr").find(".coa_id").html();
            var k = $(control).closest("tr").find(".k").html();
            var transaksiPeriksaArray = getTransaksiArray();
            var deletedTransaksi = transaksiPeriksaArray[k];
            transaksiPeriksaArray.splice(k, 1);

            var biaya = deletedTransaksi["biaya"];
            var jenis_tarif_id = deletedTransaksi["jenis_tarif_id"];
            var asuransi_id = $("#asuransi_id").val();
            $.get(
                base + "/asuransis/get/tipe_asuransi_id",
                {
                    asuransi_id: asuransi_id,
                    jenis_tarif_id: jenis_tarif_id,
                },
                function (data, textStatus, jqXHR) {
                    var tipe_asuransi_id = data["tipe_asuransi_id"];
                    var kode_coa_jenis_tarif = data["kode_coa_jenis_tarif"];
                    var kode_coa_asuransi = data["kode_coa_asuransi"];
                    console.log("kode_coa_jenis_tarif", kode_coa_jenis_tarif);
                    if (tipe_asuransi_id == 1) {
                        var totalTransaksiTunai = $(
                            "#totalTransaksiTunai"
                        ).val();
                        totalTransaksiTunai = cleanUang(totalTransaksiTunai);
                        totalTransaksiTunai -= parseInt(biaya);
                        $("#totalTransaksiTunai").autoNumeric(
                            "set",
                            totalTransaksiTunai
                        );
                    } else {
                        var totalTransaksiPiutang = $(
                            "#totalTransaksiPiutang"
                        ).val();
                        totalTransaksiPiutang = cleanUang(
                            totalTransaksiPiutang
                        );
                        totalTransaksiPiutang -= parseInt(biaya);
                        $("#totalTransaksiPiutang").autoNumeric(
                            "set",
                            totalTransaksiPiutang
                        );
                    }
                    var pleaseDeleteJurnal = true;
                    var pleaseUpdateNilaiJurnal = true;
                    var jurnals = getJurnalObject();
                    for (let i = 0, len = jurnals.length; i < len; i++) {
                        if (
                            pleaseDeleteJurnal &&
                            typeof jurnals[i] !== "undefined" &&
                            jurnals[i]["coa"]["kode_coa"] ==
                                kode_coa_jenis_tarif
                        ) {
                            jurnals.splice(i, 1);
                            pleaseDeleteJurnal = false;
                        }

                        if (
                            tipe_asuransi_id == 1 &&
                            pleaseUpdateNilaiJurnal &&
                            typeof jurnals[i] !== "undefined" &&
                            jurnals[i]["coa"]["kode_coa"] == 110000
                        ) {
                            var nilai = jurnals[i]["nilai"];
                            nilai -= parseInt(biaya);
                            jurnals[i]["nilai"] = nilai;
                        } else if (
                            pleaseUpdateNilaiJurnal &&
                            typeof jurnals[i] !== "undefined" &&
                            jurnals[i]["coa"]["kode_coa"] == kode_coa_asuransi
                        ) {
                            var nilai = jurnals[i]["nilai"];
                            nilai -= parseInt(biaya);
                            jurnals[i]["nilai"] = nilai;
                        }
                    }
                    stringifyJurnal(jurnals);
                    viewJurnals();
                }
            );

            $("#transaksis").val(JSON.stringify(transaksiPeriksaArray));
            viewTransaksiPeriksa();
        }
    });
}
function getTransaksiArray() {
    var transaksiPeriksaJson = $("#transaksis").val();
    return JSON.parse(transaksiPeriksaJson);
}
function tambahTransaksiPeriksa(control) {
    var jenis_tarif_id = $(control).closest("tr").find(".jenis_tarif_id").val();
    var asuransi_id = $("#asuransi_id").val();
    var biaya = $(control).closest("tr").find(".biaya").val();
    var keterangan_pemeriksaan = $(control)
        .closest("tr")
        .find(".keterangan_pemeriksaan")
        .val();
    var jenis_tarif = $(control)
        .closest("tr")
        .find(".jenis_tarif_id option:selected")
        .text();

    biaya = cleanUang(biaya);
    $.get(
        base + "/periksas/edit/transaksiPeriksa/get/coa_id",
        {
            jenis_tarif_id: jenis_tarif_id,
            asuransi_id: asuransi_id,
        },
        function (data, textStatus, jqXHR) {
            var baru = {
                jenis_tarif_id: jenis_tarif_id,
                jenis_tarif: {
                    jenis_tarif: jenis_tarif,
                    coa_id: data["coa_id"],
                },
                biaya: biaya,
                keterangan_pemeriksaan: keterangan_pemeriksaan,
            };

            var transaksiPeriksaArray = getTransaksiArray();
            transaksiPeriksaArray.push(baru);
            $("#transaksis").val(JSON.stringify(transaksiPeriksaArray));
            viewTransaksiPeriksa();
            reset(control);
            if (data["tipe_asuransi_id"] == 1) {
                var tunai = $("#totalTransaksiTunai").val();
                tunai = parseInt(cleanUang(tunai));
                tunai += parseInt(biaya);
                $("#totalTransaksiTunai").autoNumeric("set", tunai);
                console.log("tunai", tunai);
            } else {
                var piutang = $("#totalTransaksiPiutang").val();
                piutang = parseInt(cleanUang(piutang));
                piutang += parseInt(biaya);
                $("#totalTransaksiPiutang").autoNumeric("set", piutang);
            }
            var jurnals = getJurnalObject();
            var silahkanDitambahJurnalDiTransaksi = true;
            for (let i = 0, len = jurnals.length; i < len; i++) {
                //update nilai coa_id_asuransi agar sama
                if (
                    data["tipe_asuransi_id"] == 1 &&
                    jurnals[i]["coa"]["kode_coa"] == "110000"
                ) {
                    var nilai = jurnals[i]["nilai"];
                    nilai += parseInt(biaya);
                    jurnals[i]["nilai"] = nilai;
                } else if (jurnals[i]["coa_id"] == data["coa_id_asuransi"]) {
                    var nilai = jurnals[i]["nilai"];
                    nilai += parseInt(biaya);
                    jurnals[i]["nilai"] = nilai;
                }

                if (
                    silahkanDitambahJurnalDiTransaksi &&
                    jurnals[i]["debit"] == 0
                ) {
                    var jurnalBaru = {
                        jurnalable_id: null,
                        debit: 0,
                        nilai: biaya,
                        coa_id: data["coa_id"],
                        created_at: null,
                        updated_at: null,
                        jurnalable_type: "App\\Models\\Periksa",
                        coa: data["coa"],
                    };
                    jurnals.splice(i, 0, jurnalBaru);
                    silahkanDitambahJurnalDiTransaksi = false;
                }
            }
            stringifyJurnal(jurnals);
            viewJurnals();
        }
    );
}
function reset(control) {
    $(control)
        .closest("tr")
        .find(".jenis_tarif_id")
        .val("")
        .selectpicker("refresh");
    $(control).closest("tr").find(".biaya").val("");
    $(control).closest("tr").find(".keterangan_pemeriksaan").val("");
    $(control).closest("tr").find(".jenis_tarif").find(".btn-white").focus();
}
function viewJurnals() {
    var jurnals = getJurnalObject();
    let coa_list = $("#coa_list").val();
    coa_list = JSON.parse(coa_list);
    var temp = "";
    for (let i = 0, len = jurnals.length; i < len; i++) {
        if (jurnals[i]["nilai"] == 0) {
            jurnals.splice(i, 1);
        }
    }
    for (let i = 0, len = jurnals.length; i < len; i++) {
        selected_coa_id = jurnals[i]["coa_id"];
        temp += "<tr>";
        temp += "<td class='key hide'>";
        temp += i;
        temp += "</td>";
        temp += "<td class='hide kode_coa'>";
        temp += jurnals[i]["coa"]["kode_coa"];
        temp += "</td>";
        temp += "<td class='hide coa_id'>";
        temp += jurnals[i]["coa"]["id"];
        temp += "</td>";
        temp += "<td>";
        temp +=
            '<select class="form-control selectpicker" data-live-search="true" onChange="coaChange(this);return false;" name="coa_id">';
        for (var key in coa_list) {
            if (jurnals[i]["coa_id"] == key) {
                temp += '<option value="' + key + '" selected>';
            } else {
                temp += '<option value="' + key + '">';
            }
            temp += coa_list[key];
            temp += "</option>";
        }
        temp += "</select>";
        temp += "</td>";
        if (jurnals[i]["debit"] > 0) {
            temp += nilaiTemplate(jurnals[i]["nilai"]);
            temp += "</td>";
        } else {
            temp += "<td>";
            temp += "</td>";
        }
        if (jurnals[i]["debit"] < 1) {
            temp += nilaiTemplate(jurnals[i]["nilai"]);
            temp += "</td>";
        } else {
            temp += "<td>";
            temp += "</td>";
        }
        temp += "<td>";
        temp +=
            "<button class='btn btn-xs btn-danger' onclick='delJurnal(this);return false;'>del</button>";

        temp += "</td>";
        temp += "</tr>";
    }

    $("#container_jurnals").html(temp);

    $(".inputUang").autoNumeric("init", {
        aSep: ".",
        aDec: ",",
        aSign: "Rp. ",
        vMin: "-9999999999999.99",
        mDec: 0,
    });
    $(".selectpicker").selectpicker({
        style: "btn-default",
        size: 10,
        selectOnTab: true,
        style: "btn-white",
    });
}
function renderItem(item, index) {
    if (jurnals[i]["selected_coa_id"] == index) {
        text += '<option value="' + index + '" selected>';
    } else {
        text += '<option value="' + index + '">';
    }
    text += item;
    text += "</option>";
}
function nilaiTemplate(nilai) {
    return (
        "<td>" +
        '<input class="form-control inputUang text-right" id="" onkeyup="updateNilaiJurnal(this);return false;" name="tunai" type="text" value="' +
        nilai +
        '" autocomplete="off">' +
        "</td>"
    );
}
function updateNilaiJurnal(control) {
    var nilai = cleanUang($(control).val());
    var key = $(control).closest("tr").find(".key").html();
    var jurnals = getJurnalObject();
    jurnals[key]["nilai"] = parseInt(nilai);
    stringifyJurnal(jurnals);
}
function getJurnalObject() {
    var jurnals = $("#jurnals").val();
    return JSON.parse(jurnals);
}
function stringifyTransaksi(transaksis) {
    var transaksi = JSON.stringify(transaksis);
    $("#transaksis").val(transaksi);
}
function getPeriksaObject() {
    var periksa = $("#periksa").val();
    return JSON.parse(periksa);
}
function stringifyPeriksa(periksa) {
    var periksa = JSON.stringify(periksa);
    $("#periksa").val(periksa);
}
