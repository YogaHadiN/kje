function header(control){
	return { 
		pasien_id : $.trim($(control).closest('tr').find('.pasien_id').html()),
		meninggal : $.trim($(control).closest('tr').find('.meninggal').val()),
		verifikasi : $.trim($(control).closest('tr').find('.verifikasi').val()),
		penangguhan : $.trim($(control).closest('tr').find('.penangguhan').val()),
		kategori_prolanis: $.trim($(control).closest('tr').find('.kategori_prolanis').html()),
	}
}

function changeMeninggal(control){
	$.post( base +'/prolanis/verifikasi/ajax/meninggal',
		header(control),
		function (data, textStatus, jqXHR) {
			updateTr(data,control);
		}
	);
}

function changePenangguhan(control){
	$.post(base +'/prolanis/verifikasi/ajax/penangguhan',
		header(control),
		function (data, textStatus, jqXHR) {
			updateTr(data,control);
		}
	);
}

function changeVerifikasi(control){
	$.post(base +'/prolanis/verifikasi/ajax/verifikasi',
		header(control),
		function (data, textStatus, jqXHR) {
			updateTr(data,control);
		}
	);
}
function updateTr(data, control){
	var response = data['response'];
	if ($.trim(response) == '0') {
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Data sudah diubah, Silahkan ubah langsung di edit pasien'
		});
	} 	

	$(control).closest('tr').find('.meninggal').val( data['meninggal'] )
	$(control).closest('tr').find('.penangguhan').val( data['penangguhan_pembayaran_bpjs'] )
	$(control).closest('tr').find('.verifikasi').val( data['verifikasi_prolanis_id'] )

	if (data['verifikasi_prolanis_id'] == '2') {
		$(control).closest('tr').removeClass().addClass('success')
	} else if ( data['verifikasi_prolanis_id'] == '3' ) {
		$(control).closest('tr').removeClass().addClass('danger')
	}
}
