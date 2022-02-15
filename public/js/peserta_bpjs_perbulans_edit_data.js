function changePasien(control) {

	var id            = $(control).closest('.select_div').find('.selectPasien').val();
	var bulanTahun    = $('#bulanTahun').val();
	var nama_previous = $(control).closest('.select_div').find('.selectPasien option:selected').text();
	var nama          = $(control).closest('.panel').find('.nama_pasien').html();
	var jenis_kelamin = $(control).closest('.panel').find('.jenis_kelamin').html();
	var nama_tab      = $(control).closest('.panel').find('.jenis_prolanis').html();

	$(control).removeClass('btn-primary');
	$(control).addClass('btn-danger');

	console.log(id);
	console.log(nama_previous);
	console.log(nama);
	console.log(nama_tab);
	console.log(jenis_kelamin);
	console.log(bulanTahun);


	Swal.fire({
	  title: 'Are you sure?',
	  text: "Pasien " + id + " - " + nama_previous + " akan diubah namanya menjadi " + nama,
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Yes!'
	}).then((result) => {
	  if (result.isConfirmed) {
		$.post(base + '/peserta_bpjs_perbulans/update_data_pasien',
			{
				'id':            id ,
				'nama':          nama ,
				'bulanTahun':          bulanTahun ,
				'jenis_kelamin': jenis_kelamin ,
				'nama_tab':      nama_tab
			},
			function (data, textStatus, jqXHR) {
				if ( $.trim(data) == '1' ) {
					var message = 'Pasien berhasil diupdate namanya menjadi ' + nama;
					console.log(message);
					Swal.fire(
					  'Berhasil!',
						message,
					  'success'
					)
					$(control).closest('.panel').fadeOut();
				}
			}
		);
	  }
	})
}
