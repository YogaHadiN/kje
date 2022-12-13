$("#nomor_bpjs").focus();
var nomor_bpjs = null;
var nomor_ktp = null;
function showWhatsaappForm(control) {
    $("#noWhatsapp").modal({ backdrop: "static", keyboard: false });
    $("#jenis_antrian_id").val("");
    $("#jenis_antrian_id").val(control);
}
$("#backspace").hide();
function submitAntrian(jenis_antrian_id, no_wa) {
    var ajax_url = base + "/fasilitas/antrian_pasien/ajax/" + jenis_antrian_id;
    $(":button").prop("disabled", true);
    $.get(
        ajax_url,
        {
            nomor_bpjs: nomor_bpjs,
            nomor_ktp: nomor_ktp,
            no_wa: no_wa,
        },
        function (data, textStatus, jqXHR) {
            $("#noWhatsapp").modal("hide");
            var nomor_antrian = data["nomor_antrian"];
            var jenis_antrian = data["jenis_antrian"];
            var kode_unik = data["kode_unik"];
            var qr_code = data["qr_code"];
            var timestamp = data["timestamp"];

            $("#nomor_antrian").html(nomor_antrian);
            $("#jenis_antrian").html(jenis_antrian);
            $("#kode_unik").html(kode_unik);
            $("#qr_code").attr("src", qr_code);
            $("#timestamp").html(timestamp);

            var info_text =
                $.trim(no_wa).length == 0
                    ? jenis_antrian
                    : jenis_antrian +
                      " <br />" +
                      " <br />" +
                      " Mohon periksa pesan di whatsapp anda";
            $(":button").prop("disabled", false);
            window.print();
            Swal.fire({
                icon: "success",
                title: nomor_antrian,
                html: info_text,
                showConfirmButton: false,
                timer: 2500,
            });

            $("#nomor_bpjs").val("");
            $("#nomor_bpjs").focus();
        }
    ).fail(function (xhr) {
        showNotificationWhenError(xhr);
    });
}
function returnFocus() {
    $("#nomor_bpjs").focus();
}
function waBtn(control) {
    var number = $(control).html();
    var existingNumber = $("#no_wa").html();
    var newNumber = existingNumber + number;
    console.log("existingNumber", existingNumber, "newNumber", newNumber);
    $("#no_wa").html(newNumber);
    toggleBackspace(newNumber);
}
$("#nomor_bpjs").keyup(function (event) {
    var keycode = event.keyCode || event.which;
    if (keycode == "13") {
        nomor_bpjs = $("#nomor_bpjs").val();
        submitAntrian("1");
        nomor_bpjs = null;
    }
});
function backspace(control) {
    var existringNumber = $("#no_wa").html();
    var newNumber = existringNumber.slice(0, -1);
    $("#no_wa").html(newNumber);
    toggleBackspace(newNumber);
}

function toggleBackspace(newNumber) {
    newNumber = $.trim(newNumber);
    console.log("newNumber toggle", newNumber);
    console.log($.trim(newNumber.length), "trim. length");
    if (newNumber.length) {
        $("#backspace").show();
    } else {
        $("#backspace").hide();
    }
}

function lanjutkan(control) {
    no_wa = $.trim($("#no_wa").html());
    if (no_wa.length > 9) {
        var jenis_antrian_id = $("#jenis_antrian_id").val();
        $("#no_wa").html("");
        $("#jenis_antrian_id").val("");
        $("#backspace").hide();
        submitAntrian(jenis_antrian_id, no_wa);
    } else {
        Swal.fire({
            icon: "error",
            text: "Format Nomor handphone salah",
            showConfirmButton: false,
            timer: 2500,
        });
    }
}

function lewati(control) {
    var jenis_antrian_id = $("#jenis_antrian_id").val();
    $("#no_wa").html("");
    $("#jenis_antrian_id").val("");
    $("#backspace").hide();
    submitAntrian(jenis_antrian_id, null);
}
function showNotificationWhenError(xhr) {
    if (xhr.status === 0) {
        alert("Not connect.\n Verify Network.");
    } else if (jqXHR.status == 404) {
        alert("Requested page not found. [404]");
    } else if (jqXHR.status == 500) {
        alert("Internal Server Error [500].");
    } else {
        alert("Uncaught Error.\n" + jqXHR.responseText);
    }
}
