function submitPage(){
    var pembayaran = $('#pembayaran_pasien').val();
    var periksa_id = $('#periksa_id').val();
    console.log('periksa_id');
    console.log(periksa_id);
    pembayaran = cleanUang(pembayaran);
    $.get(base + '/periksas/cek_customer_survey_sudah_diisi',
        { periksa_id: periksa_id },
        function (data, textStatus, jqXHR) {
            data = $.trim(data);
                var submit                  = true;
                var dibayar_pasien          = $('#dibayar_pasien').val();
                dibayar_pasien              = cleanUang(dibayar_pasien);
                var pembayaran_pasien       = $('#pembayaran_pasien').val();
                var pembayaran_pasien_clean = cleanUang(pembayaran_pasien);
                if( 
                    parseInt( asuransi_id ) != 0 &&
                    parseInt( asuransi_id ) != 32 &&
                    parseInt( cleanUang( $('#dibayar_asuransi').val() ) ) < 1 &&
                    parseInt( cleanUang( $('#pembayaran_pasien').val() ) ) > 0
                ){
                    console.log('true');
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text:'Tidak bisa dilanjutkan, Kalau Pasien bayar semua sendiri rubah dulu asuransi pasien menjadi Biaya Pribadi'
                    });
                    return false;
                }
                

                $('.tabelTerapi2 td').each(function(e) {
                    if($(this).css('color') !='rgb(255, 0, 0)' ){
                        submit = false;
                        return false;
                    }
                });
    $.get(base + '/periksas/' + periksa_id + '/cek/jumlah/berkas',
        { periksa_id: periksa_id },
        function (data, textStatus, jqXHR) {
            var jumlah_berkas = $.trim(data)
            if(submit){
                if($('#dibayar_asuransi').val() == ''){
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Asuransi harus diisi walaupun dengan angka 0 ..'
                    });
                    validasi('#dibayar_asuransi', 'harus diisi walau dengan 0');
                }else if(pembayaran_pasien == '' ){
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Pembayaran harus diisi walaupun dengan angka 0 ..'
                    });
                    validasi('#pembayaran_pasien', 'harus diisi walau dengan 0');
                }else if( parseInt( dibayar_pasien ) > parseInt( pembayaran_pasien_clean ) ) {
                    Swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Pembayaran Pasien tidak benar'
                    });
                    validasi('#pembayaran_pasien', 'Pembayaran Pasien tidak benar');
                // }else if( tipe_asuransi == '3' && parseInt(jumlah_berkas) <1 ) {
                //     Swal.fire({
                //       icon: 'error',
                //       title: 'Oops...',
                //       text: 'Asuransi Admedika harus diupload Bukti Pemeriksaan Asuransi Yang sudah ditandatangani'
                //     });
                //     validasi('#file_upload_periksa', 'Harus diupload Bukti Pemeriksaan Asuransi');
                // }else if( $('#klaim_gdp_bpjs').val() == '' ) {
                //     Swal.fire({
                //       icon: 'error',
                //       title: 'Oops...',
                //       text: 'Bukti Klaim Gula Darah harus di upload'
                //     });
                //     validasi('#klaim_gdp_bpjs', 'Harus diupload Bukti Klaim Gula Darah BPJS');
                }else { 
                    $('#print').click();
                    $('.btn').attr('disabled','disabled');
                }
            } else {
               alert('Mohon Periksa / Cek ulang apakah obat yang akan diberikan sesuai dengan resep!');
            }
        }
    );
        }
    );
}
