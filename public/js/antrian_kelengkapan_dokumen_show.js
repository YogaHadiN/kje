  function dummySubmit(control){
      tipe_asuransi = $('#tipe_asuransi').val();
    $.get(base + '/periksas/' + periksa_id + '/cek/jumlah/berkas',
        { periksa_id: periksa_id },
        function (data, textStatus, jqXHR) {
            var jumlah_berkas = $.trim(data)
            if( tipe_asuransi == '3' && parseInt(jumlah_berkas) <1 ) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Asuransi Admedika harus diupload Bukti Pemeriksaan Asuransi Yang sudah ditandatangani'
                });
                validasi('#file_upload_periksa', 'Harus diupload Bukti Pemeriksaan Asuransi');
            }else if( $('#klaim_gdp_bpjs').val() == '' ) {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Bukti Klaim Gula Darah harus di upload'
                });
                validasi('#klaim_gdp_bpjs', 'Harus diupload Bukti Klaim Gula Darah BPJS');
            } else { 
                $('#submit').click();
                $('.btn').attr('disabled','disabled');
            }
        }
    );
  }

