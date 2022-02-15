	function dummySubmit(control){

		if(
		 $('#piutang_tercatat').val() != '[]' &&
		 $('#piutang_tercatat').val() != ''
		){
			if(validatePass2(control)){
				$('#submit').click();
			}
		} else {
			alert('Belum ada tagihan yang dicek');
			return false;
		}
	}
	$('#postKirimBerkas').find('.staf_id')
	.selectpicker({
		style: 'btn-default',
		size: 10,
		selectOnTab : true,
		style : 'btn-white'
	});
	function cariPiutangAsuransi(){
		 $("#body_pencarian_piutang").html("<tr><td colspan='2'></td><td colspan='2' class='text-center'><img src='" + base_s3 + "/img/loader.gif'></td><td colspan='3'></td></tr>");
		$.get(base + '/kirim_berkas/cari/piutang',
			{ 
				asuransi_id: $('#asuransi_id').val(),
				date_from:   $('#date_from').val(),
				date_to:     $('#date_to').val()
			},
			function (data, textStatus, jqXHR) {
				if( data.length > 0 ){
					var temp = viewTemp(data);
					$('#body_pencarian_piutang').html(temp);
					var string =  JSON.stringify( data ) ;
					$('#piutang_asuransi').val(string);
				} else {
					$('#piutang_asuransi').val('[]');
					$("#body_pencarian_piutang").html("<tr><td colspan='7' class='text-center'>Tidak ada data yang dapat ditampilkan</td></tr>");
				}
			}
		);
	}
	function cekPiutang(x, control){
		x = $.trim(x);
		var data = parsePiutangAsuransi();
		var catat = data[x];
		piutang_tercatat = parsePiutangTercatat();
		piutang_tercatat.push(catat);
		$('#piutang_tercatat').val(JSON.stringify(piutang_tercatat));
		var temp = viewTemp( piutang_tercatat, true );
		$('#body_piutang_tercatat').html(temp);
		var n = piutang_tercatat.length - 1;
		$(control).closest('td').html( buttonCek(n, false) );
	}
	function viewTemp(data, catat = false){
		var temp = ''; 
		var data_piutang_tercatat = parsePiutangTercatat();
		for (var i = 0; i < data.length; i++) {
			if( data[i].tanggal_kirim != null ){
				temp += '<tr class="warning">';
			} else if(
				 data[i].piutang == null ||
				 data[i].sudah_dibayar == null
			) {
				temp += '<tr class="danger">';
			} else {
				temp += '<tr>';
			}
			temp += '<td><a target="_blank" href="' + base + '/periksas/' +data[i].periksa_id+ '">';
			temp += data[i].periksa_id;
			temp += '</a></td>';
			temp += '<td>';
			temp += data[i].nama_pasien;
			temp += '</td>';
			temp += '<td class="hide">';
			temp += data[i].piutang_id;
			temp += '</td>';
			temp += '<td>';
			temp += data[i].nama_asuransi;
			temp += '</td>';
			temp += '<td nowrap class="text-right">';
			temp += uang(data[i].piutang);
			temp += '</td>';
			temp += '<td nowrap class="text-right">';
			temp += uang(data[i].sudah_dibayar);
			// temp += uang(data[i].sudah_dibayar);
			temp += '</td>';
			temp += '<td nowrap class="text-right">';
			// temp += uang(data[i].piutang - data[i].sudah_dibayar);
			temp += uang(data[i].piutang - data[i].sudah_dibayar);
			temp += '</td>';
			if(catat){
				temp += '<td nowrap class="column-fit">';
				temp += buttonCek(i, false);
				temp += '</td>';
			} else {
				if( data[i].tanggal_kirim != null ){
						temp += '<td nowrap>';
						temp += 'Terkirim ' + data[i].tanggal_kirim;
						temp += '</td>';
				} else {
					var tercatat = cekTercatat( data_piutang_tercatat, data[i].piutang_id );
					if (typeof tercatat !== "boolean"){
						temp += '<td class="column-fit">';
						temp += buttonCek(tercatat, false);
						temp += '</td>';
					} else {
						temp += '<td class="column-fit">';
						temp += buttonCek(i);
						temp += '</td>';
					}
				}
			}
			temp += '</tr>';
		}
		if( catat ){
			var grouped                   = _.groupBy(data, 'nama_asuransi');
			var htmlTemp                  = '';
			var isNan                     = false;
			var keseluruhan_tagihan       = 0;
			var keseluruhan_total_tagihan = 0;
			for (var key in grouped) {
				var jumlah_tagihan = grouped[key].length;
				var total_tagihan = 0;

				for (var i = 0; i < grouped[key].length; i++) {
					if (
						grouped[key][i].piutang !== null &&
						grouped[key][i].sudah_dibayar !== null
					) {
						total_tagihan += parseInt(grouped[key][i].piutang) - parseInt(grouped[key][i].sudah_dibayar);
					}
				}
				htmlTemp += '<tr>';
				htmlTemp += '<td>';
				htmlTemp += key;
				htmlTemp += '</td>';
				htmlTemp += '<td class="text-right">';
				htmlTemp +=  jumlah_tagihan + ' tagihan';
				htmlTemp += '</td>';
				htmlTemp += '<td class="text-right">';
				htmlTemp +=  uang(total_tagihan);
				htmlTemp += '</td>';
				htmlTemp += '</tr>';

				if (jumlah_tagihan !== null){
					keseluruhan_tagihan += jumlah_tagihan;
				} else {
					isNan = true;
				}

				if (total_tagihan !== null){
					keseluruhan_total_tagihan += total_tagihan;
				} else {
					isNan = true;
				}
			}
			htmlTemp += '<tr>';
			htmlTemp += '<td>';
			htmlTemp += '</td>';
			htmlTemp += '<td class="text-right"><strong>';
			htmlTemp +=  keseluruhan_tagihan + ' tagihan';
			htmlTemp += '</strong></td>';
			htmlTemp += '<td class="text-right"><strong>';
			htmlTemp +=  uang(keseluruhan_total_tagihan);
			htmlTemp += '</strong></td>';
			htmlTemp += '</tr>';
			$('#rekap_pengecekan').html(htmlTemp);
		}
		if (isNan) {
			Swal.fire({
			  icon: 'error',
			  title: 'Oops...',
			  text: 'Beberapa transaksi ada yang belum diselesaikan, Harap selesaikan dahulu sebelum mengirim invoice'
			})
		}
		return temp;
	}
	function uncekPiutang(n, control){
		var piutang_tercatat = parsePiutangTercatat();
		piutang_tercatat.splice(n, 1);
		var temp = viewTemp(piutang_tercatat, true);
		$('#piutang_tercatat').val( JSON.stringify( piutang_tercatat ) );
		$('#body_piutang_tercatat').html(temp);

		var data_piutang_pencarian = parsePiutangAsuransi();
		var temp = viewTemp(data_piutang_pencarian);
		$('#piutang_asuransi').val( JSON.stringify( data_piutang_pencarian ) );
		$('#body_pencarian_piutang').html(temp);

	}
	
	function parsePiutangTercatat(){
		var json_piutang_tercatat =$('#piutang_tercatat').val(); 
		var piutang_tercatat = $.parseJSON(json_piutang_tercatat);
		return piutang_tercatat;
	}
	function buttonCek(i, cek = true){
		if( cek ){
			 return '<button type="button" onclick="cekPiutang(' + $.trim(i) + ', this); return false;" class="btn btn-info">Cek</button>'
		} else {
			 return '<button type="button" onclick="uncekPiutang(' + $.trim(i) + ', this); return false;" class="btn btn-danger">Uncek</button>'
		}
	}
	function cekTercatat( data, piutang_id ){
		var ada = false;
		for (var i = 0; i < data.length; i++) {
			if( data[i].piutang_id == piutang_id ){
				ada = i;
				break;
			}
		}
		return ada
	}

	function cekSemua(){
		var piutang_asuransi = parsePiutangAsuransi();
		var piutang_tercatat = parsePiutangTercatat();

		for (var i = 0; i < piutang_asuransi.length; i++) {
			if( 
				typeof cekTercatat( piutang_tercatat, piutang_asuransi[i].piutang_id ) === 'boolean' &&
				piutang_asuransi[i].tanggal_kirim == null

			){
				piutang_tercatat.push( piutang_asuransi[i]  );
			}
		}

		var temp = viewTemp( piutang_tercatat, true );

		$('#body_piutang_tercatat').html(temp);
		$('#piutang_tercatat').val( JSON.stringify(piutang_tercatat) );

		var temp = viewTemp(piutang_asuransi);
		$('#body_pencarian_piutang').html(temp);
	}

	function parsePiutangAsuransi(){
		var json =$('#piutang_asuransi').val(); 
		var data = $.parseJSON(json);
		return data;
	}
	function uncekSemua(){
		var piutang_tercatat = parsePiutangTercatat();
		var data = parsePiutangAsuransi();
		for (var i = 0; i < piutang_tercatat.length; i++) {
			if( typeof cekTercatat( data, piutang_tercatat[i].piutang_id ) !== 'boolean' ){
				piutang_tercatat.splice(i,1);
				i = i-1;
			}
		}
		$('#piutang_tercatat').val( JSON.stringify(piutang_tercatat) );
		var temp = viewTemp(data);
		$('#body_pencarian_piutang').html(temp);
		temp = viewTemp(piutang_tercatat, true);
		$('#body_piutang_tercatat').html( temp );
	}
	function tambahStaf(control){
		var staf_id         = $(control).closest('.row').find('.staf_id').val();
		var role_pengiriman = $(control).closest('.row').find('.role_pengiriman').val();
		var staf_tervalidasi = false;
		var role_pengiriman_tervalidasi = false;
		if( staf_id ){
			staf_tervalidasi = true;
		} else {
			validasiin(control, '.staf_id', 'Nama Staf harus diisi');
		}
		if(role_pengiriman){
			role_pengiriman_tervalidasi = true;
		} else {
			validasiin(control, '.role_pengiriman', 'Role Pengiriman harus diisi');
		}

		if( staf_tervalidasi && role_pengiriman_tervalidasi) {
			tambah(control)
		}
	}

	function kurangStaf(control){

		$(control).closest('.row').remove();
		 
	}
	function tambah(control){
		var temp = $('#staf_container').html();
		$(control).closest('.row').after(temp);
		$(control).closest('.row').next().find('.staf_id').selectpicker({
			style: 'btn-default',
			size: 10,
			selectOnTab : true,
			style : 'btn-white'
		});
		$(control).closest('.row').next().find('.btn-white').focus();
		$(control)
			.removeClass('btn-success')
			.addClass('btn-danger')
			.html('<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>')
			.attr('onclick','kurangStaf(this);return false;')
	}
	function validasiin(control, classSelector, pesan){
		$(control).closest('.row').find(classSelector) 
		.parent()
		.find('code')
		.remove();

		$(control).closest('.row').find(classSelector) 
		.parent()
		.addClass('has-error')
		.append('<code>' + pesan + '</code>');

		$(control).closest('.row').find(classSelector) 
		.parent()
		.find('code')
		.hide()
		.fadeIn(1000);

		$(control).closest('.row').find(classSelector) 
	   .on('keyup change', function(){
		  $(this).parent()
		  .removeClass('has-error')
		  .find('code')
		  .fadeOut('1000', function() {
			  $(this).remove();
		  });
	   })   
	}
