function panggil(antrian_id, ruangan, panggil_pasien) {
    panggil_pasien = panggil_pasien || true;
    ruangan = $("#ruangan").val();
    if (ruangan !== "") {
        $.get(
            base + "/poli/ajax/panggil_pasien",
            {
                antrian_id: antrian_id,
                panggil_pasien: panggil_pasien,
                ruangan: ruangan,
            },
            function (data) {
                console.log("Panggil berhasil");
                Swal.fire({
                    icon: "success",
                    title: "Panggil pasien berhasil",
                    showConfirmButton: false,
                    timer: 1000,
                });
            }
        );
        // .error(function () {
        // console.log("error kampret");
        // Swal.fire({
        //     icon: "error",
        //     title: "Oops...",
        //     text: "Ada kesalahan. Mohon hubungi admin",
        // });
        // });
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Harap untuk dapat memilih ruangan terlebih dahulu",
        }).then((result) => {
            setTimeout(function () {
                $("#ruangan").closest(".form-group").addClass("has-error");
                $("#ruangan")
                    .closest(".form-group")
                    .find("code")
                    .removeClass("hide");
                $("#ruangan").focus();
            }, 500);
        });
    }
}
