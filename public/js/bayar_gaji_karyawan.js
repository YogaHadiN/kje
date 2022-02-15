  if( $('#print').length > 0 ){
	window.open(base + '/pdfs/bayar_gaji_karyawan/' + session_print, '_blank');
  }
  function dummySubmit(){
	  console.log('uyeye');
	  var tanggal_benar      = false;
	  var tanggal_dibayar    = $('#tanggal_dibayar').val();
	  var periode            = $('#periode').val();
	  var tahun_periode      = periode.split("-")[1];
	  var bulan_periode      = parseInt( periode.split("-")[0] );
	  var last_date          = daysInMonth(bulan_periode, tahun_periode);
	  var tanggal_terakhir   = last_date.getDate();
	  var tanggal_terakhir   = tanggal_terakhir + '-' + periode;
	  var strTanggalDibayar  = strTime( tanggal_dibayar );
	  var strTanggalTerakhir = strTime( tanggal_terakhir );

	  if( strTanggalDibayar > strTanggalTerakhir ){
		  tanggal_benar = true;
	  }
	if (
		validatePass() && 
		tanggal_benar &&
		kolomGajiTerisiSemua()
	) {
	  $('#submit').click();
	} else if( !tanggal_benar ){
		var pesan =  'Tanggal dibayar harus setelah akhir periode bulan';
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text:pesan
		});

		validasi('#tanggal_dibayar', pesan);
		validasi('#periode',pesan);
	}
  }
function tambah(control) {
	var nama_staf = $(control).closest('tr').find('.nama_staf_select').val();
	var gaji_pokok = $(control).closest('tr').find('.gaji_pokok_text').val();
	var jumlah_bonus = $(control).closest('tr').find('.jumlah_bonus_text').val();
	var validated = true;

	if (
		nama_staf == '' ||
		gaji_pokok == '' ||
		jumlah_bonus == ''
	) {
		validated = false;
		if (nama_staf == '') {
			validasi1($(control).closest('tr').find('.nama_staf_select'), 'Harus Diisi!');
		}
		if (gaji_pokok == '') {
			validasi1($(control).closest('tr').find('.gaji_pokok_text'), 'Harus Diisi!');
		}
		if (jumlah_bonus == '') {
			validasi1($(control).closest('tr').find('.jumlah_bonus_text'), 'Harus Diisi!');
		}
	}
	if (validated) {
		var temp = $(control).closest('tr')[0].outerHTML;
		$(control).closest('tr').after(temp);
		var select_template = $('#select_template').html(); 
		$(control).closest('tr').next().find('.nama_staf').html(select_template);
		$(control).closest('tr').next().find('.nama_staf_select').selectpicker({
			style: 'btn-default',
			size: 10,
			selectOnTab : true,
			style : 'btn-white'
		});
		$(control).closest('tr').next().find('.nama_staf').find('.btn-white').focus();
		$(control).closest('tr').next().find('.uangInput').autoNumeric('init', {
			aSep: '.',
			aDec: ',', 
			aSign: 'Rp. ',
			vMin: '-9999999999999.99' ,
			mDec: 0
		});
		var key = parseInt($(control).closest('tr').find('.key').html());
		key++;
		$(control).closest('tr').next().find('.key').html(key);
	}

}
function changeNamaStaf(control) {
	var staf_id = $(control).val();
	var key = parseInt($(control).closest('tr').find('.key').html());
	var container_gaji = $('#container_gaji').val();
	container_gaji = $.parseJSON(container_gaji);
	if ( 
		typeof container_gaji[key] === 'undefined'
	) {
		container_gaji[key] = {
			'staf_id' : staf_id
		};
	} else {
		container_gaji[key].staf_id = staf_id;
	}
	container_gaji = JSON.stringify(container_gaji);
	$('#container_gaji').val(container_gaji)
}
function changeJumlahBonus(control) {
	var jumlah_bonus   = $(control).val();
	jumlah_bonus       = cleanUang(jumlah_bonus);
	var key            = parseInt($(control).closest('tr').find('.key').html());
	var container_gaji = $('#container_gaji').val();
	container_gaji     = $.parseJSON(container_gaji);
	if ( 
		typeof container_gaji[key] === 'undefined'
	) {
		container_gaji[key] = {
			'jumlah_bonus' : jumlah_bonus
		};
	} else {
		container_gaji[key].jumlah_bonus = jumlah_bonus;
	}
	container_gaji = JSON.stringify(container_gaji);
	$('#container_gaji').val(container_gaji)
}
function changeGajiPokok(control) {
	var gaji_pokok     = $(control).val();
	gaji_pokok         = cleanUang(gaji_pokok);
	var key            = parseInt($(control).closest('tr').find('.key').html());
	var container_gaji = $('#container_gaji').val();
	container_gaji     = $.parseJSON(container_gaji);
	if ( 
		typeof container_gaji[key] === 'undefined'
	) {
		container_gaji[key] = {
			'gaji_pokok' : gaji_pokok
		};
	} else {
		container_gaji[key].gaji_pokok = gaji_pokok;
	}
	container_gaji = JSON.stringify(container_gaji);
	$('#container_gaji').val(container_gaji)
}
function kurang(control) {
	var table_rows = $('#tabel_daftar_gaji tbody tr').length;
	if ( table_rows < 2 ) {
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Tidak dapat menghapus Baris terakhir'
		});

		  // text: 'Tidak dapat menghapus Baris terakhir'
	} else {
		var key = parseInt($(control).closest('tr').find('.key').html());
		var container_gaji = $('#container_gaji').val();
		container_gaji     = $.parseJSON(container_gaji);
		container_gaji.splice(key, 1);
		$(control).closest('tr').remove();
		table_rows = $('#tabel_daftar_gaji tbody tr').length;
		console.log('table_rows');
		console.log(table_rows);
		container_gaji = JSON.stringify(container_gaji);
		$('#container_gaji').val(container_gaji)
		for (var i = 0, len = table_rows; i < len; i++) {
			var row_number = parseInt(i) + 1;
			$('#tabel_daftar_gaji tbody tr:nth-child(' + parseInt(row_number) + ')').find('.key').html(i);
		}
	}
}
function kolomGajiTerisiSemua() {
	var passed = true;
	$('input.this_required, select.this_required').each(function() {
		if ( $(this).val() == '' ) {
			validasi1($(this), 'Harus Diisi!');
			passed = false;
		}
	})
	if (!passed) {
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Semua kolom gaji harus diisi, atau silahkan hapus yang tidak lengkap karena tidak akan dimasukkan di database'
		});
	}
	return passed;
}
