function printStruk(control){
	alert( $(control).closest('tr').find('.periksa_id').html() );
}

function updateAsuransiPeriksa(control){
	var asuransi_id     = $(control).val();
	var nama_asuransi     = $(control).find('option:selected').text();
	var periksa_id      = $(control).closest('tr').find('.periksa_id').html();
	var nama_pasien     = $(control).closest('tr').find('.nama_pasien').html();
	var tanggal         = $(control).closest('tr').find('.tanggal').html();
	var old_asuransi_id = $(control).closest('tr').find('.old_asuransi_id').html();
	Swal.fire({
		title:             'Are you sure?',
		text:              'Anda Yakin mau merubah asuransi pemeriksaan ' + periksa_id+ '-' + nama_pasien+ ' Pada tanggal ' + tanggal  + ' menjadi ' + nama_asuransi + '?',
		showCancelButton:  true,
		confirmButtonText: `Ok`,
	}).then((result) => {
	  if (result.isConfirmed) {
		$.post(base + '/laporans/harian/update_asuransi',
			{ 
				'asuransi_id': asuransi_id ,
				'periksa_id': periksa_id
			},
			function (data, textStatus, jqXHR) {
				data = $.trim(data)
				if ( data == 0 ) {
					Swal.fire({
					  icon: 'error',
					  title: 'Oops...',
					  text:'Ada kesalahan, asuransi tidak bisa diubah'
					});

					resetAsuransiId(control);
				} else {
					Swal.fire({
					  icon: 'success',
					  title: 'Berhasil!!',
					  text:'Asuransi pemeriksaan ' + nama_pasien + ' berhasil di update '
					});
					$(control).closest('tr').find('.old_asuransi_id').html(asuransi_id);
				}
		});
      } else {
		resetAsuransiId(control);
      }
	})
}
function resetAsuransiId(control) {
	var old_asuransi_id = $(control).closest('tr').find('.old_asuransi_id').html();
	$(control).val( old_asuransi_id );
	$(control).selectpicker('refresh');
}

