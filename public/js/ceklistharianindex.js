search();
var auth_id = $("#auth_id").val();
var csrf_token = $('meta[name="csrf-token"]').attr("content");
var timeout;
var length = $("#container").closest("table").find("thead").find("th").length;
function clearAndSearch(key = 0) {
    $("#container").html(
        "<tr><td colspan='" +
            length +
            "' class='text-center'><img class='loader' src='" +
            base_s3 +
            "/img/loader.gif'></td></tr>"
    );
    window.clearTimeout(timeout);
    timeout = window.setTimeout(function () {
        if ($("#paging").data("twbs-pagination")) {
            $("#paging").twbsPagination("destroy");
        }
        search(key);
    }, 600);
}
function search(key = 0) {
    var pages;
    var url = "/cek_list_harians/byTanggal/search";
    $.get(
        base + url,
        {
            tanggal: $("#tanggal").val(),
            displayed_rows: $("#displayed_rows").val(),
            key: key,
        },
        function (data, textStatus, jqXHR) {
            var temp = "";
            for (var i = 0; i < data.data.length; i++) {
                temp += "<tr>";
                temp += '<td nowrap class="kolom_1">';
                temp +=
                    ' <a href="' +
                    base +
                    "/cek_list_dikerjakans/byTanggal/" +
                    data.data[i].tanggal +
                    '" target="_blank">';
                temp += data.data[i].tanggal;
                temp += "</a>";
                temp += "</td>";
                temp += "</tr>";
            }
            $("#container").html(temp);
            $("#rows").html(data.rows);
            pages = data.pages;
            if (data.data.length) {
                $("#paging").twbsPagination({
                    startPage: parseInt(key) + 1,
                    totalPages: pages,
                    visiblePages: 7,
                    onPageClick: function (event, page) {
                        search(parseInt(page) - 1);
                    },
                });
            }
        }
    );
}
