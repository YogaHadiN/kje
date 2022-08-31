function selectPasien(key = 0) {
    var url = $("form#ajaxkeyup").attr("action");
    var data = $("form#ajaxkeyup").serializeArray();
    data[data.length] = {
        name: "key",
        value: key,
    };

    var displayed_rows = $("#displayed_rows").val();
    var DDID_PASIEN = $("#id").closest("th").hasClass("displayNone");
    var DDID_ASURANSI = $("#nama_asuransi")
        .closest("th")
        .hasClass("displayNone");
    var DDnomorAsuransi = $("#nomor_asuransi")
        .closest("th")
        .hasClass("displayNone");
    var DDnamaPeserta = $("#nama_peserta")
        .closest("th")
        .hasClass("displayNone");
    var DDnamaIbu = $("#nama_ibu").closest("th").hasClass("displayNone");
    var DDnamaAyah = $("#nama_ayah_Input")
        .closest("th")
        .hasClass("displayNone");

    $.get(url, data, function (hasil) {
        alert("asu");
        var MyArray = hasil.data;
        var pages = hasil.pages;
        var rows = hasil.rows;
        var temp = "";
        for (var i = 0; i < MyArray.length; i++) {
            temp += "<tr";
            console.log(" MyArray[i].sudah_berobat_bulan_ini ");
            console.log(MyArray[i].sudah_berobat_bulan_ini);
            if (MyArray[i].sudah_berobat_bulan_ini) {
                temp += " class='table-primary' ";
            }
            temp += ">";
            if (DDID_PASIEN) {
                temp +=
                    "<td nowrap class='displayNone'><div>" +
                    MyArray[i].ID_PASIEN +
                    "</div></td>";
            } else {
                temp +=
                    "<td nowrap class=''><div>" +
                    MyArray[i].ID_PASIEN +
                    "</div></td>";
            }
            temp +=
                "<td nowrap><div>" +
                caseNama(MyArray[i].namaPasien) +
                "</div></td>";
            temp +=
                "<td class='kolom_2'><div>" +
                caseNama(MyArray[i].alamat) +
                "</div></td>";
            temp +=
                "<td nowrap class='kolom_3'><div>" +
                MyArray[i].tanggalLahir +
                "</div></td>";
            temp += "<td nowrap><div>" + MyArray[i].noTelp + "</div></td>";
            if (DDID_ASURANSI) {
                temp +=
                    "<td nowrap class='displayNone'><div>" +
                    caseNama(MyArray[i].namaAsuransi) +
                    "</div></td>";
            } else {
                temp +=
                    "<td nowrap class=''><div>" +
                    caseNama(MyArray[i].namaAsuransi) +
                    "</div></td>";
            }
            if (DDnomorAsuransi) {
                temp +=
                    "<td nowrap class='displayNone'><div>" +
                    MyArray[i].nomorAsuransi +
                    "</div></td>";
            } else {
                temp +=
                    "<td nowrap class=''><div>" +
                    MyArray[i].nomorAsuransi +
                    "</div></td>";
            }
            if (DDnamaPeserta) {
                temp +=
                    "<td nowrap class='displayNone'><div>" +
                    caseNama(MyArray[i].namaPeserta) +
                    "</div></td>";
            } else {
                temp +=
                    "<td nowrap class=''><div>" +
                    caseNama(MyArray[i].namaPeserta) +
                    "</div></td>";
            }
            if (DDnamaIbu) {
                temp +=
                    "<td nowrap class='displayNone'><div>" +
                    caseNama(MyArray[i].namaIbu) +
                    "</div></td>";
            } else {
                temp +=
                    "<td nowrap class=''><div>" +
                    caseNama(MyArray[i].namaIbu) +
                    "</div></td>";
            }
            if (DDnamaAyah) {
                temp +=
                    "<td nowrap class='displayNone'><div>" +
                    caseNama(MyArray[i].namaAyah) +
                    "</div></td>";
            } else {
                temp +=
                    "<td nowrap class=''><div>" +
                    caseNama(MyArray[i].namaAyah) +
                    "</div></td>";
            }

            temp +=
                "<td nowrap class='displayNone'><div>" +
                MyArray[i].asuransi_id +
                "</div></td>";
            temp +=
                "<td nowrap class='displayNone'><div>" +
                MyArray[i].image +
                "</div></td>";
            temp +=
                '<td nowrap nowrap><div><a href="#" style="color: green; font-size: large;" onclick="rowEntry(this);return false;"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>';
            temp +=
                '&nbsp;&nbsp;&nbsp;<a href="pasiens/' +
                MyArray[i].ID_PASIEN +
                '/edit" style="color: ##337AB7; font-size: large;"><span aria-hidden="true" class="glyphicon glyphicon-edit"></span></a>';
            temp +=
                '&nbsp;&nbsp;&nbsp;<a href="pasiens/' +
                MyArray[i].ID_PASIEN +
                '/transaksi" style="color: ##337AB7; font-size: large;"><i class=\'fas fa-money-bill-wave-alt\'></i></a>';
            temp +=
                "&nbsp;&nbsp;&nbsp;<a data-value='" +
                MyArray[i].ID_PASIEN +
                '\' onclick=\'confirmStafModal(this);\' href=\'#\' style="color: orange; font-size: large;" ><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a> </td>';

            temp += "</tr>";
        }
        $("#ajax").html(temp);
        if (key > 0) {
            $("#paging").twbsPagination({
                startPage: parseInt(key) + 1,
                totalPages: pages,
                visiblePages: 7,
                onPageClick: function (event, page) {
                    selectPasien(parseInt(page) - 1);
                },
            });
        }
        $("#rows").html(numeral(rows).format("0,0"));
    });
}
