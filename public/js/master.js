$(document).ready(function () {
    $("input").attr("autocomplete", "off");
    $(".uangInput").autoNumeric("init", {
        aSep: ".",
        aDec: ",",
        aSign: "Rp. ",
        vMin: "-9999999999999.99",
        mDec: 0,
    });
    formatUang();
    $(".jumlah").each(function () {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html(number);
    });

    $(".selectpick").selectpicker({
        style: "btn-default",
        size: 10,
        selectOnTab: true,
        style: "btn-white",
    });
    //plug in datetimepicker waktu bebas terserah
    $(".tanggal").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: "dd-mm-yyyy",
    });
    $(".tanggal").closest("form").attr("autocomplete", "off");
    $(".bulanTahun").datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: "mm-yyyy",
        minViewMode: "months",
    });

    $(".DTa").dataTable({
        dom: 'T<"clear">lfrtip',
    });

    $(".DTs").dataTable({
        dom: 'T<"clear">lfrtip',
        bSort: false,
        searching: false,
    });

    $(".DTsWithI").dataTable({
        dom: 'T<"clear">lfrtip',
        searching: false,
    });

    $(".DT").dataTable({
        dom: 'T<"clear">lfrtip',
        bSort: false,
    });

    $('[data-toggle="tooltip"]').tooltip();

    $(".DTi").dataTable({
        aaSorting: [[6, "desc"]],
        responsive: true,
        dom: 'T<"clear">lfrtip',
        // "bSort" : false,
        tableTools: {
            sSwfPath: "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf",
        },
    });
    /* Init DataTables */
    var oTable = $("#editable").dataTable();
    /* Apply the jEditable handlers to the table */
    oTable.$("td").editable("../example_ajax.php", {
        callback: function (sValue, y) {
            var aPos = oTable.fnGetPosition(this);
            oTable.fnUpdate(sValue, aPos[0], aPos[1]);
        },
        submitdata: function (value, settings) {
            return {
                row_id: this.parentNode.getAttribute("id"),
                column: oTable.fnGetPosition(this)[2],
            };
        },
        width: "90%",
        height: "100%",
    });
});
function fnClickAddRow() {
    $("#editable")
        .dataTable()
        .fnAddData(["Custom row", "New row", "New row", "New row", "New row"]);
}
function updateLandingLinkClass() {
    var jumlah_antrian = $("#jumlah_antrian").html();
    if (
        parseInt(jumlah_antrian) > 0 &&
        !$("#jumlah_antrian").closest("li").hasClass("landing_link")
    ) {
        $("#jumlah_antrian").closest("li").addClass("landing_link");
    } else if (
        parseInt(jumlah_antrian) < 1 &&
        $("#jumlah_antrian").closest("li").hasClass("landing_link")
    ) {
        $("#jumlah_antrian").closest("li").removeClass("landing_link");
    }
    $("#jumlah_antrian")
        .closest("li")
        .fadeOut(function () {
            $(this).fadeIn();
        });
}
function playBell() {
    document.getElementById("myAudio").play();
}
function delayCall(i, second_round) {
    i.play();
}
function pglPasien(sound) {
    // var suara = [];
    // for (var i = 0, len = sound.length; i < len; i++) {
    //     suara[i]         = new Audio();
    //     suara[i].src     = base + '/sound/' + sound[i];;
    //     suara[i].preload = 'auto';
    // }

    // for (var i = 0, len = suara.length; i < len; i++) {
    //     suara[i].play();
    //     setTimeout
    //

    var x = document.getElementById("myAudio");
    var m = [];
    for (var i = 0, len = sound.length; i < len; i++) {
        m[i] = document.getElementById("audio_" + sound[i]);
    }
    x.onended = function () {
        if (typeof m[0] === "object" && m[0] !== null) {
            m[0].play();
        }
    };

    m[0].onended = function () {
        if (typeof m[1] === "object" && m[1] !== null) {
            m[1].play();
        }
    };
    m[1].onended = function () {
        if (typeof m[2] === "object" && m[2] !== null) {
            m[2].play();
        }
    };
    m[2].onended = function () {
        if (typeof m[3] === "object" && m[3] !== null) {
            m[3].play();
        }
    };
    m[3].onended = function () {
        if (typeof m[4] === "object" && m[4] !== null) {
            m[4].play();
        }
    };
    m[4].onended = function () {
        if (typeof m[5] === "object" && m[5] !== null) {
            m[5].play();
        }
    };
    x.play();
    // m[0].play();
    // m[1].play();
    // m[2].play();
    // m[3].play();
    // m[4].play();
    // m[5].play();

    // delay = 0;
    // for (var i = 0, len = m.length; i < len; i++) {
    //     var duration = (m[i].duration * 1000);
    //     setTimeout(
    //         delayCall(m[i], delay),
    //     delay);
    //     delay = Math.ceil(delay + (m[i].duration * 1000));
    // }

    // }

    // for (var i = 0, len = audio.length; i < len; i++) {
    //     audio[i].addEventListener('ended', function(){
    //         if (i < audio.length -1) {
    //             audio[i+1].play();
    //         }
    //     });
    // }

    // var x     = document.getElementById("myAudio");
    // x.play();
    // var index = 0;
    // x.onended = function() {
    // 	if(index < sound.length){
    // 		x = audio[index];
    // 		x.play();
    // 		index++;
    // 	}
    // };
    //
    //
    // audio[0].onended=function(){
    //  setTimeout(function(){
    //   audio[1].play()
    //  ;}, audio[0].duration * 1000);
    // };
    // audio[0].play();

    // var audio = new Audio(),
    //     i = 0;
    // var playlist = sound;

    // audio.addEventListener('ended', function () {
    //     i = ++i < playlist.length ? i : 0;
    //     audio = suara[i];
    //     audio.play();
    // }, true);
    // audio.loop = false;
    // audio.src = base + '/sound/' + playlist[0];;
    // audio.play();
    //
    var x = document.getElementById("myAudio");
    x.play();
    var index = 0;
    x.onended = function () {
        if (index < sound.length) {
            x.src = base + "/sound/" + sound[index];
            x.play();
            index++;
        }
    };
}
function pusherCaller() {
    var channel_name = "my-channel";
    var event_name = "form-submitted";

    Pusher.logToConsole = true;

    var pusher = new Pusher("281b6730814874b6b533", {
        cluster: "ap1",
        forceTLS: true,
    });

    var channel = pusher.subscribe(channel_name);
    channel.bind(event_name, function (data) {
        $("#jumlah_antrian").html(data.text.count);
        updateLandingLinkClass();
    });
}
function validatePass2(control, extraValid = []) {
    var pass = true;
    var value = "";
    var param = [
        {
            selector: ".rq",
            testFunction: validateNotEmpty,
            message: "Harus diisi",
        },
        {
            selector: ".tanggal",
            testFunction: validatedate,
            message: "Format Tanggal tidak benar",
        },
        {
            selector: ".numeric",
            testFunction: validateNumeric,
            message: "Format Tanggal tidak benar",
        },
        {
            selector: ".email",
            testFunction: validateEmail,
            message: "Format Email tidak benar",
        },
        {
            selector: ".phone",
            testFunction: validatePhone,
            message: "Format Telepon tidak benar",
        },
    ];
    for (var i = 0, len = extraValid.length; i < len; i++) {
        param.push(extraValid[i]);
    }
    var unvalidated_columns = [];
    for (var i = 0, len = param.length; i < len; i++) {
        $(control)
            .closest("form")
            .find(param[i].selector + ":not(div)")
            .each(function (index, el) {
                value = $(this).val();
                if (!param[i].testFunction(value)) {
                    var label = $(this)
                        .closest(".form-group")
                        .find("label")
                        .html();
                    unvalidated_columns.push(label);
                    validasi1($(this), param[i].message);
                    pass = false;
                }
            });
    }
    if (!pass) {
        var columns = "";
        for (var i = 0, len = unvalidated_columns.length; i < len; i++) {
            columns += unvalidated_columns[i];
            if (i != unvalidated_columns.length) {
                columns += ", ";
            }
        }

        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: columns + " Harus harus diperbaiki sebelum submit!",
            didClose: () => {
                $(control)
                    .closest("form")
                    .find(".rq")
                    .each(function (index, el) {
                        if ($(this).val() == "") {
                            $(this).focus();
                            return false;
                        }
                    });
            },
        });
    }
    return pass;
}
$("form input").keydown(function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});
