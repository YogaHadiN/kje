if (
    $("#previous_complaint_resolved").val() == 0 ||
    $("#alergi_obat").val() == 1
) {
    var error_message = "<ul>";
    if ($("#previous_complaint_resolved").val() == 0) {
        error_message += "<li>";
        error_message += $("#text_previous_complaint_resolved").html();
        error_message += "</li>";
    }
    if ($("#alergi_obat").val() == 0) {
        error_message += "<li>";
        error_message += $("#text_alergi_obat").html();
        error_message += "</li>";
    }
    error_message += "</ul>";
    $("#alergi_obat").val() == 1;
    Swal.fire({
        title: "Perhatian Khusus",
        html: error_message,
        icon: "warning",
    });
}
