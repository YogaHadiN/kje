$("#tanggal_lahir").datepicker({
	todayBtn: "linked",
	keyboardNavigation: false,
	forceParse: false,
	calendarWeeks: true,
	autoclose: true,
	format: 'dd-mm-yyyy'
}).on('changeDate', function (ev) {
	if ( $(this).val() != '' ) {
		if ( moment($(this).val(), 'DD-MM-YYYY',true).isValid()  ) {
			console.log('true');
			$.get(base + '/pasiens/cek/tanggal_lahir/sama',
				{ tanggal_lahir_cek : $(this).val() },
				function (data, textStatus, jqXHR) {
					var temp = '';
					for (var i = 0, len = data.length; i < len; i++) {

						var duplicate = checkIfDuplicate(data, data[i].nama);

						temp += '<tr';
						if (duplicate) {
							temp += ' class="danger"';
						}
						temp += '>';
						temp += '<td class="nama">';
						temp += data[i].nama;
						temp += '</td>';
						temp += '<td class="alamat">';
						temp += data[i].alamat;
						temp += '</td>';
						temp += '<td class="no_telp">';
						temp += data[i].no_telp;
						temp += '</td>';
						temp += '<td class="detil_action">';
						temp += '<a class="btn btn-info btn-sm" href="' + base + '/pasiens/' + data[i].id + '/edit"><i class="fas fa-info"></i></button>'
						temp += '</td>';
						temp += '</tr>';
					}
					if ( data.length > 0 ) {
						$('#row_ajax_container').fadeIn('slow');
					}
					$('#ajax_container').html(temp);
				}
			);
		} else {
			console.log('false');
			validasi1($(this), 'Format Tanggal Salah, harusnya dd-mm-yyyy');
		}
	}
});
	
function checkIfDuplicate(data,nama) {

	var count = 0;
	for (var i = 0, len = data.length; i < len; i++) {
		if (nama.substring(0, 3) == data[i].nama.substring(0, 3)) {
			count++;
		}
	}

	if (count > 1) {
		return true;
	}
	return false;
}
function cekNomorBpjsSama(control) {
	var asuransi_id = $('#asuransi_id').val();
	if ( 
		asuransi_id == '32' &&
		$(control).val().length > 12
	) {
		$.get( base + '/pasiens/cek/nomor_bpjs/sama',
			{ 
				nomor_bpjs: $(control).val()
			},
			function (data, textStatus, jqXHR) {
				if (data['duplikasi'] == '1') {
					validasi1($(control), 'Nomor BPJS yang sama sudah digunakan oleh <a href="' + base + '/pasiens/' + data['pasien']['id']+ '/edit">' + data['pasien']['nama'] + '</a>');
				}
			}
		);
	} else {
	}
}
