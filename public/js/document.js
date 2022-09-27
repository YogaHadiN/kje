documentKeyUp();
function documentKeyUp() {
    var id = $("#id").val();
    var nama = $("#nama").val();
    var tanggal = $("#tanggal").val();

    $.get(
        base + "/document/search",
        {
            id: id,
            nama: nama,
            tanggal: tanggal,
        },
        function (data, textStatus, jqXHR) {
            $("#container").html(view(data));
        }
    );
}

function del(control) {
    var id = $(control).closest("tr").find(".id").html();
    $.post(
        base + "/document/ajax/delete",
        {
            id: id,
        },
        function (data, textStatus, jqXHR) {
            $("#container").html(view(data));
        }
    );
}
function view(data) {
    var temp = "";
    if (data.length > 0) {
        for (let i = 0, len = data.length; i < len; i++) {
            var loc = base_s3 + "/" + data[i].url;
            temp += "<tr>";
            temp += "<td class='id'>";
            temp += data[i].id;
            temp += "</td>";
            temp += "<td>";
            temp += data[i].nama;
            temp += "</td>";
            temp += "<td>";
            temp += data[i].tanggal;
            temp += "</td>";
            temp += "<td>";
            temp +=
                "<a href='" +
                loc +
                "' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-download-alt'></span></a> ";
            temp +=
                '<button onclick="del(this);return false;" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></button>';
            temp += "</td>";
            temp += "</tr>";
        }
    } else {
        temp += "<tr>";
        temp += '<td colspan="4" class="warning text-center">';
        temp += "Tidak ada data untuk ditampilkan";
        temp += "</td>";
        temp += "</tr>";
    }
    return temp;
}
