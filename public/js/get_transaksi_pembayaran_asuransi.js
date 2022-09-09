var order_by = {
    column_name: "bulan",
    order: "desc",
};

$("body").on("click", ".getOrderPiutang", function () {
    order_by = {
        column_name: $(this).data("column_name"),
        order: $(this).data("order"),
    };
    asuransiChange();
    $(".getOrderPiutang").each(function () {
        var caret = "";
        var newOrder = "desc";
        if (!($(this).data("column_name") == order_by["column_name"])) {
            $(this).find("i").remove();
        } else {
            if (order_by["order"] == "asc" || order_by["order"] == "no") {
                caret = '<i class="fas fa-caret-down"></i>';
                newOrder = "desc";
            } else {
                caret = '<i class="fas fa-caret-up"></i>';
                newOrder = "asc";
            }
            $(this).find("i").remove();
            $(this).append(caret);
            $(this).data("order", newOrder);
        }
    });
});

$("body").on("keyup", ".orderPiutangSearchParameter", function () {
    asuransiChange();
});

function asuransiChange(key = 0) {
    if ($("#pagination-twbs").data("twbs-pagination")) {
        $("#pagination-twbs").twbsPagination("destroy");
    }
    getAsuransi(key);
}
function getAsuransi(key = 0) {
    displaySpinner();
    var nama_asuransi = $("#asuransi_id").find("option:selected").text();
    var displayed_rows = $("#displayed_rows_piutang").val();

    var asuransi_id = $("#asuransi_id").val();
    var param = {
        asuransi_id: asuransi_id,
        piutang: $("#piutang").val(),
        displayed_rows: displayed_rows,
        bulan: $("#bulan").val(),
        sudah_dibayar: $("#sudah_dibayar").val(),
        sisa: $("#sisa").val(),
        column_order: order_by["column_name"],
        order: order_by["order"],
        key: key,
    };
    console.log("param");
    console.log(param);
    $.post(
        base + "/pendapatans/pembayaran/asuransis/riwayatHutang",
        param,
        function (data) {
            var temp = "";
            var total_rows = data.total_rows;
            var data = data.result;
            for (let i = 0, len = data.length; i < len; i++) {
                var sudah_dibayar = 0;
                if (data[i].sudah_dibayar !== null) {
                    sudah_dibayar = data[i].sudah_dibayar;
                }
                var piutang = 0;
                if (data[i].piutang !== null) {
                    piutang = data[i].piutang;
                }
                temp += "<tr>";
                temp += "<td nowrap>";
                temp += '<a href="';
                temp += base;
                temp += "/periksas/cari/by_asuransi/";
                temp += asuransi_id;
                temp += "/";
                temp += Date.parse(data[i].bulan).toString("yyyy-MM-01");
                temp += "/";
                temp += Date.parse(data[i].bulan)
                    .moveToLastDayOfMonth()
                    .toString("yyyy-MM-dd");
                temp += '" target="_blank"> ';
                temp += Date.parse(data[i].bulan).toString("yyyy-MM");
                temp += "</a>";
                temp += "</td>";
                if (parseInt(Date.parse(data[i].bulan).toString("dd")) == 1) {
                    temp += "<td nowrap>";
                    temp += '<a href="';
                    temp += base;
                    temp += "/periksas/cari/by_asuransi/";
                    temp += asuransi_id;
                    temp += "/";
                    temp += Date.parse(data[i].bulan).toString("yyyy-MM-01");
                    temp += "/";
                    temp += Date.parse(data[i].bulan).toString("yyyy-MM-15");
                    temp += '" target="_blank"> ';
                    temp += "2 mg pertama";
                    temp += "</a>";
                    temp += "</td>";
                } else {
                    temp += "<td nowrap>";
                    temp += '<a href="';
                    temp += base;
                    temp += "/periksas/cari/by_asuransi/";
                    temp += asuransi_id;
                    temp += "/";
                    temp += Date.parse(data[i].bulan).toString("yyyy-MM-16");
                    temp += "/";
                    temp += Date.parse(data[i].bulan)
                        .moveToLastDayOfMonth()
                        .toString("yyyy-MM-dd");
                    temp += '" target="_blank"> ';
                    temp += "2 mg terakhir";
                    temp += "</a>";
                    temp += "</td>";
                }
                temp += '<td class="uang" nowrap>' + piutang + "</td>";
                temp += '<td class="uang" nowrap>' + sudah_dibayar + "</td>";
                temp +=
                    '<td class="uang" nowrap>' +
                    (parseInt(piutang) - parseInt(sudah_dibayar)) +
                    "</td>";
                temp += "</tr>";
            }
            $("#riwayatHutang").html(temp);
            $("#namaAsuransi").html(
                '<a href="' +
                    base +
                    "/asuransis/" +
                    asuransi_id +
                    '/hutang/pembayaran">Riwayat Hutang' +
                    nama_asuransi +
                    "</a>"
            );
            $("#table_riwayat_hutang")
                .find(".uang")
                .each(function () {
                    var money = uang($(this).html());
                    $(this).html(money);
                });
            var visible_pages = 7;
            var total_pages = Math.ceil(total_rows / 8);
            if (data.length) {
                $("#pagination-twbs").twbsPagination({
                    startPage: parseInt(key) + 1,
                    totalPages: total_pages,
                    visiblePages: visible_pages,
                    onPageClick: function (event, page) {
                        getAsuransi(parseInt(page) - 1);
                    },
                });
            }
        }
    );
}
function displaySpinner() {
    var colspan = $("#riwayatHutang")
        .closest("table")
        .find("thead tr")
        .find("th:not(.displayNone)").length;
    $("#riwayatHutang").html(
        "<td colspan='" +
            colspan +
            "'><img class='loader' src='" +
            base_s3 +
            "/img/loader.gif' /></td>"
    );
}
var order_by_bulanan = {
    column_name: "bulan",
    order: "desc",
};
$("body").on("click", ".getOrderPiutangBulanan", function () {
    order_by_bulanan = {
        column_name: $(this).data("column_name"),
        order: $(this).data("order"),
    };
    asuransiChangeBulanan();
    $(".getOrderPiutangBulanan").each(function () {
        var caret = "";
        var newOrder = "desc";
        if (!($(this).data("column_name") == order_by_bulanan["column_name"])) {
            $(this).find("i").remove();
        } else {
            if (
                order_by_bulanan["order"] == "asc" ||
                order_by_bulanan["order"] == "no"
            ) {
                caret = '<i class="fas fa-caret-down"></i>';
                newOrder = "desc";
            } else {
                caret = '<i class="fas fa-caret-up"></i>';
                newOrder = "asc";
            }
            $(this).find("i").remove();
            $(this).append(caret);
            $(this).data("order", newOrder);
        }
    });
});

$("body").on("keyup", ".orderPiutangSearchParameterBulanan", function () {
    asuransiChangeBulanan();
});

function asuransiChangeBulanan(key = 0) {
    if ($("#pagination-twbs").data("twbs-pagination")) {
        $("#pagination-twbs").twbsPagination("destroy");
    }
    getAsuransiBulanan(key);
}
function getAsuransiBulanan(key = 0) {
    displaySpinnerBulanan();
    var nama_asuransi = $("#asuransi_id").find("option:selected").text();
    var displayed_rows = $("#displayed_rows_piutang_bulanan").val();

    var asuransi_id = $("#asuransi_id").val();
    var param = {
        asuransi_id: asuransi_id,
        piutang: $("#piutang_bulanan").val(),
        displayed_rows: displayed_rows,
        bulan: $("#bulan_bulanan").val(),
        sudah_dibayar: $("#sudah_dibayar_bulanan").val(),
        sisa: $("#sisa_bulanan").val(),
        column_order: order_by_bulanan["column_name"],
        order: order_by_bulanan["order"],
        key: key,
    };
    $.post(
        base + "/pendapatans/pembayaran/asuransis/riwayatHutang/bulanan",
        param,
        function (data) {
            var temp = "";
            var total_rows = data.total_rows;
            var data = data.result;
            for (let i = 0, len = data.length; i < len; i++) {
                var sudah_dibayar = 0;
                if (data[i].sudah_dibayar !== null) {
                    sudah_dibayar = data[i].sudah_dibayar;
                }
                var piutang = 0;
                if (data[i].piutang !== null) {
                    piutang = data[i].piutang;
                }
                temp += "<tr>";
                temp += "<td nowrap>";
                temp += '<a href="';
                temp += base;
                temp += "/periksas/cari/by_asuransi/";
                temp += asuransi_id;
                temp += "/";
                temp += Date.parse(data[i].bulan).toString("yyyy-MM-01");
                temp += "/";
                temp += Date.parse(data[i].bulan)
                    .moveToLastDayOfMonth()
                    .toString("yyyy-MM-dd");
                temp += '" target="_blank"> ';
                temp += Date.parse(data[i].bulan).toString("yyyy-MM");
                temp += "</a>";
                temp += "</td>";
                temp += '<td class="uang" nowrap>' + data[i].piutang + "</td>";
                temp += '<td class="uang" nowrap>' + sudah_dibayar + "</td>";
                temp +=
                    '<td class="uang" nowrap>' +
                    (parseInt(data[i].piutang) - parseInt(sudah_dibayar)) +
                    "</td>";
                temp += "</tr>";
            }
            $("#riwayatHutangBulanan").html(temp);
            $("#table_riwayat_hutang_bulanan")
                .find(".uang")
                .each(function () {
                    var money = uang($(this).html());
                    $(this).html(money);
                });
            var visible_pages = 7;
            var total_pages = Math.ceil(total_rows / 8);
            if (data.length) {
                $("#pagination-twbs-bulanan").twbsPagination({
                    startPage: parseInt(key) + 1,
                    totalPages: total_pages,
                    visiblePages: visible_pages,
                    onPageClick: function (event, page) {
                        getAsuransiBulanan(parseInt(page) - 1);
                    },
                });
            }
        }
    );
}
function displaySpinnerBulanan() {
    var colspan = $("#riwayatHutangBulanan")
        .closest("table")
        .find("thead tr")
        .find("th:not(.displayNone)").length;
    $("#riwayatHutangBulanan").html(
        "<td colspan='" +
            colspan +
            "'><img class='loader' src='" +
            base_s3 +
            "/img/loader.gif' /></td>"
    );
}
