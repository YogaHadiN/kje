var totalBiaya = 0;
var totalAwal = 0;

$(document).ready(function () {
    inputTaccChange();
    $(".jumlah").keyup(function (e) {
        var awal = $(this).closest("tr").find("td:nth-child(7)").html();
        var id = $(this).closest("tr").find("td:last-child").html();

        console.log("awal = " + awal);
        console.log("id = " + id);

        if (parseInt($(this).val()) > awal) {
            $(this).val(awal);
        } else if ($(this).val() < 0) {
            $(this).val("0");
        }

        var n = $(this).val();
        updateJumlah(id, n, this);
    });
});

function ddlOnChange(control) {
    var jumlah = $(control).closest("tr").find("input").val();
    var js = $(control).val();
    var MyArray = JSON.parse(js);
    var merek_id = MyArray.merek_id;
    var rak_id = MyArray.rak_id;
    var asuransi_id = $("#asuransi_id").val();
    var formula_id = MyArray.formula_id;
    var harga_jual = MyArray.harga_jual;
    var harga_beli = MyArray.harga_beli;
    var fornas = MyArray.fornas;
    var id = $(control).closest("tr").find(".terapi_id").html();
    var i = $(control).closest("tr").find(".key").html();
    var data = parseTerapi();
    var kali_obat = $("#kali_obat").val();

    data[i].merek_id = merek_id;
    data[i].harga_beli_satuan = harga_beli;
    data[i].harga_jual_satuan = harga_jual * kali_obat;
    encodeTerapi(data, harga_jual, control, jumlah, fornas);
}

function tambah(control) {
    var id = $(control).closest("tr").find("td:last-child").html();
    var awal = $(control).closest("tr").find("td:nth-child(7)").html();
    var n = $(control).closest(".spinner").find("label").html();
    if (n != awal) {
        n++;
        updateJumlah(id, n, control);
    }
}
function kurang(control) {
    var id = $(control).closest("tr").find("td:last-child").html();
    var n = $(control).closest(".spinner").find("label").html();
    if (n != 0) {
        n--;
        updateJumlah(id, n, control);
    }
}

function updateJumlah(id, n, control) {
    $.post(
        "/kasir/updatejumlah",
        { id: id, jumlah: n },
        function (data, textStatus, xhr) {
            updateTerapi(data);
            var harga = $(control).closest("tr").find("td:nth-child(5)").html();
            harga = Number(harga.replace(/[^0-9]+/g, ""));
            $(control)
                .closest("tr")
                .find(".total_satuan")
                .html(parseInt(n) * parseInt(harga));
            hitungTotal();
            rupiah();
        }
    );
}

function updateTerapi(data) {
    data = $.parseJSON(data);
    if (data.confirm == "1") {
        var terapi = data.terapi;
        $("#terapih").html(terapi);
        $("#terapi2").val(JSON.stringify(data.terapiJson));
    }
}

function rupiah() {
    $('.uang:not(:contains("Rp"))').each(function () {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html("Rp. " + number + ",-");
    });
}

function dummyClick(control) {
    if (
        $("#inputTacc").length > 0 &&
        ($("#tacc_muncul").val() == "" || $("#tacc_muncul").val() == null)
    ) {
        alert(
            "Apakah pilihan Tacc keluar pada rujukan? Mohon diisi dengan benar"
        );
        validasi("#tacc_muncul", "Harus diisi!");
    } else if (
        $("#inputTacc").length > 0 &&
        $("#tacc_muncul").val() == "1" &&
        ($("#time_tacc").val() == "" || $("#time_tacc").val() == null) &&
        ($("#age_tacc").val() == "" || $("#age_tacc").val() == null) &&
        ($("#complication_tacc").val() == "" ||
            $("#complication_tacc").val() == null) &&
        ($("#comorbidity_tacc").val() == "" ||
            $("#comorbidity_tacc").val() == null)
    ) {
        validateWarning("#time_tacc");
        validateWarning("#age_tacc");
        validateWarning("#complication_tacc");
        validateWarning("#comorbidity_tacc");
    } else if (validatePass2(control)) {
        $("#submit").click();
    }
}

function hitungTotal() {
    var total = 0;
    $(".totalItem").each(function (index, el) {
        var string = $(this).html();
        string = parseInt(Number(string.replace(/[^0-9]+/g, "")));
        total += parseInt(string);
    });
    var nama_poli = $("#nama_poli").val();
    if (nama_poli != "Poli Estetika") {
        $("#biaya").html(rataAtas5000(total));
    } else {
        $("#biaya").html(total);
    }
}

function inputTaccChange() {
    if (
        $("#tacc_muncul").val() == "" ||
        $("#tacc_muncul").val() == null ||
        $("#tacc_muncul").val() == "0"
    ) {
        $("#inputTacc").removeClass("hide");
        $("#inputTacc").slideUp("500");
        $("#tacc_muncul").closest(".panel").find("textarea").val("");
    } else {
        $("#inputTacc").removeClass("hide");
        $("#inputTacc").hide();
        $("#inputTacc").slideDown("500");
    }
}
function validateWarning(selector) {
    if ($(selector).val() == "" || $(selector).val() == null) {
        validasi(selector, "Harus Diisi");
    }
}
function parseTerapi() {
    var temp = $("#terapi1").val();
    return $.parseJSON(temp);
}
function encodeTerapi(temp, harga_jual, control, jumlah, fornas) {
    console.log("harga_jual", harga_jual);
    var temp = JSON.stringify(temp);
    $("#terapi1").val(temp);
    $("#terapi2").val(temp);
    var tipe_asuransi_id = $("#tipe_asuransi_id").val();
    var kali_obat = $("#kali_obat").val();
    console.log("kali_obat", kali_obat);
    if (tipe_asuransi_id == "5") {
        // BPJS
        if (fornas == 0) {
            $(control)
                .closest("tr")
                .find(".harga_satuan")
                .html(Math.floor(harga_jual * kali_obat));
        } else {
            $(control).closest("tr").find(".harga_satuan").html("0");
        }
    } else {
        $(control)
            .closest("tr")
            .find(".harga_satuan")
            .html(Math.floor(harga_jual * kali_obat));
        $(control)
            .closest("tr")
            .find(".total_satuan")
            .html(Math.floor(harga_jual * kali_obat * jumlah));
    }
    hitungTotal();
    rupiah();
}

function jumalhEdit(control) {
    var i = $(control).closest("tr").find(".key").html();
    var harga_jual = hargaJual(control);
    var awal = $(control).closest("tr").find(".jumlah").html();
    var id = $(control).closest("tr").find(".terapi_id").html();
    var merek_jual = $(control).closest("tr").find(".merek_jual").val();
    MyArray = JSON.parse(merek_jual);
    var fornas = MyArray.fornas;

    if (parseInt($(control).val()) > awal) {
        var jumlah = awal;
    } else if ($(control).val() < 0) {
        var jumlah = 0;
    } else {
        var jumlah = $(control).val();
    }
    $(control).val(jumlah);

    var data = parseTerapi();
    data[i].jumlah = jumlah;
    encodeTerapi(data, harga_jual, control, jumlah, fornas);
}
function hargaJual(control) {
    var MyArray = $(control).closest("tr").find("select").val();
    MyArray = $.parseJSON(MyArray);
    return MyArray.harga_jual;
}
function cunamEdit(control) {
    var i = $(control).closest("tr").find(".key").html();
    console.log(i);
    var data = parseTerapi();
    data[i].cunam_id = parseInt($(control).val());
    var harga_jual = hargaJual(control);
    var jumlah = $(control).closest("tr").find(".jumlah").val();
    var merek_jual = $(control).closest("tr").find(".merek_jual").val();
    MyArray = JSON.parse(merek_jual);
    var fornas = MyArray.fornas;

    encodeTerapi(data, harga_jual, control, jumlah, fornas);
}
