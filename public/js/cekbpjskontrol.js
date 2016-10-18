function cekBPJSkontrol(ID, asuransi_id){


	 if (asuransi_id == '32') {
		$.post(base + '/pasiens/ajax/cekbpjskontrol', {'pasien_id': ID, 'asuransi_id' : asuransi_id}, function(data, textStatus, xhr) {
		  /*optional stuff to do after success */
		  MyArray = $.parseJSON(data);
		  var data = MyArray.kode;
		  var tanggal = MyArray.tanggal;
		  if (tanggal != '' && tanggal != null) {
			var text = 'Pasien sudah periksa GDS bulan ini tanggal ' + tanggal;
		  } else {
			var text = 'GDS gratis untuk BPJS hanya untuk riwayat kencing manis atau usia > 50 tahun usia pasien saat ini ' + MyArray.tanggal_lahir;
		  }
		  $('#karena').html(text)

		  if (data == '3') {
			$('#cekBPJSkontrol').show();
			$('#cekGDSBPJS').show();
		  } else if(data == '2'){
			$('#cekBPJSkontrol').show();
			$('#cekGDSBPJS').hide();
		  } else if(data == '1'){
			$('#cekBPJSkontrol').hide();
			$('#cekGDSBPJS').show();
		  } else {
			$('#cekBPJSkontrol').hide();
			$('#cekGDSBPJS').hide();
		  }
		});
		$('#pengantar_pasien').show();
	 } else {
	    $('#cekBPJSkontrol').hide();
		$('#pengantar_pasien').hide();
	 }
	 
}
