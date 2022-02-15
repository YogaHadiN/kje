	temp = parseTemp();
	render(temp);
	function dummySubmit(control){
		var htg = hitung();
		var kredit            = htg.kredit;
		var debit             = htg.debit;
		var biaya             = htg.biaya;
		var total_periksa     = htg.total_periksa;
		var total_harta_masuk = htg.total_harta_masuk;

		callValue(htg);

		if( 
			kredit == debit &&
			biaya == total_periksa &&
			biaya == total_harta_masuk
		){
			if(validatePass2(control)){
				$('#submit').click();
			}
		} else {
			if( kredit != debit ){
				alert('Jumlah Debit = ' + uang( debit ) + ', kredit = ' + uang( kredit ) + ' , HARUS SAMA!');
			}
			if( biaya != total_periksa  || biaya != total_harta_masuk){
				alert('Jumlah Biaya = ' + uang( biaya ) + ', Total Periksa = ' + uang( total_periksa ) + ' Total Harta Yang Masuk = ' + uang( total_harta_masuk )+ ', HARUS SAMA!');
			}
		}
	}
	function nilaiTransaksi(control){
		var nilai             = cleanUang( $(control).val() );
		var key               = $(control).attr('title');
		var jurnals           = $('#jurnals').val();
		jurnals               = JSON.parse(jurnals);
		jurnals[key]['biaya'] = nilai;
		jurnals               = JSON.stringify(jurnals);
		$('#jurnlas').val(jurnals);
		$('#debit_total').html(hitung().debit);
		$('#kredit_total').html(hitung().kredit);
	}
	
	function refreshTunaiPiutang(){
		var temp = parseTemp();
		var total_transaksi = 0;
		var transaksis      = $('#transaksis').val();
		transaksis = JSON.parse(transaksis);
		for (let i = 0, len = transaksis.length; i < len; i++) {
			total_transaksi += parseInt(transaksis[i].biaya);
		}
		console.log(total_transaksi);
		var tunai   = cleanUang($('#tunai').val());
		var piutang = 0;
		if (tunai > total_transaksi) {
			$('#tunai').val(uang(total_transaksi))
			piutang = 0;
			$('#piutang').val(uang(piutang))
		}else if( tunai== '' ){
			tunai = 0;
			piutang = total_transaksi;
			$('#tunai').val(uang(tunai));
			$('#piutang').val(uang(piutang));
		} else {
			piutang        = total_transaksi - tunai;
			$('#piutang').val(uang(piutang));
		}

		var asuransi_coa_id = $('#asuransi_coa_id').html()
		var key_by_coa = null;
		var temp_coa_exist = false;
		for (let i = 0, len = temp.length; i < len; i++) {
			if (temp[i].coa_id == asuransi_coa_id) {
				temp_coa_exist = true;
				key_by_coa = i;
				break;
			}
		}
		if ( $('.' + asuransi_coa_id)[0] ) {
			$('.' + asuransi_coa_id).find('input').val(uang(piutang));
			nilaiKeyUp($('.' + asuransi_coa_id).find('input'));
		} else if (
			!$('.' +asuransi_coa_id )[0] &&
			!temp_coa_exist
		) {
			$.get(base + '/coas/get/coa_name',
				{ coa_id: asuransi_coa_id },
				function (data, textStatus, jqXHR) {
					var newElement = { 
							"coa": data,
							"coa_id": asuransi_coa_id,
							"nilai": piutang,
							"debit": 1
						};
					temp.push(newElement);
					render(temp)
				}
			);
		} else if (
			!$('.' +asuransi_coa_id )[0] &&
			temp_coa_exist &&
			piutang > 0
		) {
			temp[key_by_coa].nilai = piutang;
			render(temp);
		} else if (
			!$('.' +asuransi_coa_id )[0] &&
			temp_coa_exist &&
			piutang < 1
		) {
			temp.splice( key_by_coa , 1);
			render(temp);
		}

		var periksa        = $('#periksa').val();
		periksa            = JSON.parse(periksa);
		periksa['tunai']   = tunai;
		periksa['piutang'] = piutang;
		periksa            = JSON.stringify(periksa);
		$('#periksa').val(periksa);

		var temp = parseTemp();
		var coa_tunai_tersedia = false;
		for (let i = 0, len = temp.length; i < len; i++) {
			if (temp[i].coa_id.substring(0,3) == '110') {
				coa_tunai_tersedia = true;
			}
		}
		if ( 
			$('.name_110')[0]
		) {
			$('.name_110').first().closest('tr').find('.nilai').val(uang(tunai));
			nilaiKeyUp($('.name_110').first().closest('tr').find('.nilai'));
		} else if (
			tunai > 0 &&
			!$('.name_110')[0] &&
			!coa_tunai_tersedia
		) {
			var newElement = { 
					"coa":"Kas di kasir",
					"coa_id":"110000",
					"nilai": tunai,
					"debit":"1" 
				};
			temp[temp.length] = newElement;
			render(temp);
		} else if (
			tunai > 0 &&
			!$('.name_110')[0] &&
			coa_tunai_tersedia
		) {
			temp[getKey(temp)].nilai = tunai;
			render(temp);
		} else if (
			tunai == 0 &&
			!$('.name_110')[0] &&
			coa_tunai_tersedia
		) {
			temp.splice(getKey(temp), 1);
			render(temp);
		}
	}
	function coaChange(control){
		var key             = parseInt( $(control).closest('tr').find('.key').html() );
		var coa_id          = $(control).val();
		var data            = $('#jurnals').val();
		data                = JSON.parse(data);
		data[key]['coa_id'] = coa_id;
		data                = JSON.stringify(data);
		$('#jurnals').val(data);
	}

	function nilaiKeyUp(control){
		var key            = parseInt( $(control).closest('tr').find('.key').html() );
		var nilai          = cleanUang( $(control).val() );
		var data           = $('#jurnals').val();
		data               = JSON.parse(data);
		data[key]['nilai'] = parseInt( nilai );
		data               = JSON.stringify(data);
		$('#jurnals').val(data);
		var htg            = hitung();
		callValue(htg);

	}
	function transaksiPeriksa(control){

		var nilai = cleanUang( $(control).val() );
		var key   = $(control).attr('title');

		var transaksis        = $('#transaksis').val();
		transaksis            = JSON.parse(transaksis);
		transaksis[key].biaya = nilai;
		transaksis            = JSON.stringify( transaksis );

		var coa_id = $(control).closest('tr').find('.coa_id').html();
		var temp_coa_exist = false;
		var key_by_coa = null;

		for (let i = 0, len = temp.length; i < len; i++) {
			if (temp[i].coa_id == coa_id) {
				temp_coa_exist = true;
				key_by_coa = i;
				break;
			}
		}
		if ( $('.' +coa_id )[0] ) {
			$('.' + coa_id).find('input').val(uang(nilai));
			nilaiKeyUp($('.' + coa_id).find('input'));
		} else if (
			!$('.' +coa_id )[0] &&
			!temp_coa_exist
		) {
			$.get(base + '/coas/get/coa_name',
				{ coa_id: coa_id },
				function (data, textStatus, jqXHR) {
					var newElement = { 
							"coa": data,
							"coa_id": coa_id,
							"nilai": nilai,
							"debit": 0
						};
					temp.push(newElement);
					render(temp)
				}
			);
		} else if (
			!$('.' +coa_id )[0] &&
			temp_coa_exist &&
			nilai > 0
		) {
			temp[key_by_coa].nilai = nilai;
			render(temp);
		} else if (
			!$('.' +coa_id )[0] &&
			temp_coa_exist &&
			nilai < 1
		) {
			temp.splice( key_by_coa , 1);
			render(temp);
		}

		var nilai_total_transaksi_periksa = 0;
		$('.nilai_transaksi_periksa').each(function(){
			var nilai_transaksi_periksa = $(this).find('input').val()
			nilai_total_transaksi_periksa += parseInt(cleanUang(nilai_transaksi_periksa));
		});

		var nilai_tunai               = cleanUang($('#tunai').val()) ;
		var nilai_piutang             = cleanUang($('#piutang').val()) ;
		var nilai_total_piutang_tunai = parseInt(nilai_tunai) + parseInt(nilai_piutang)


		var selisih = nilai_total_transaksi_periksa - nilai_total_piutang_tunai;

		nilai_piutang = parseInt(nilai_piutang) + parseInt(selisih);
		$('#piutang').val(uang(nilai_piutang));
		updatePeriksa(nilai_piutang, 'piutang');

		var asuransi_coa_id = $('#asuransi_coa_id').html()
		key_by_coa = null;
		temp_coa_exist = false;
		for (let i = 0, len = temp.length; i < len; i++) {
			if (temp[i].coa_id == asuransi_coa_id) {
				temp_coa_exist = true;
				key_by_coa = i;
				break;
			}
		}
		if ( $('.' + asuransi_coa_id)[0] ) {
			$('.' + asuransi_coa_id).find('input').val(uang(nilai_piutang));
			nilaiKeyUp($('.' + asuransi_coa_id).find('input'));
		} else if (
			!$('.' +asuransi_coa_id )[0] &&
			!temp_coa_exist
		) {
			$.get(base + '/coas/get/coa_name',
				{ coa_id: asuransi_coa_id },
				function (data, textStatus, jqXHR) {
					var newElement = { 
							"coa": data,
							"coa_id": asuransi_coa_id,
							"nilai": nilai,
							"debit": 1
						};
					temp.push(newElement);
					render(temp)
				}
			);
		} else if (
			!$('.' +asuransi_coa_id )[0] &&
			temp_coa_exist &&
			nilai > 0
		) {
			temp[key_by_coa].nilai = nilai;
			render(temp);
		} else if (
			!$('.' +asuransi_coa_id )[0] &&
			temp_coa_exist &&
			nilai < 1
		) {
			temp.splice( key_by_coa , 1);
			render(temp);
		}


		$('#transaksis').val(transaksis);
		$('#biaya_total').html(hitung().biaya);

		var htg = hitung();
		callValue(htg);
	}
	function hitung(){
			var jurnals    = $('#jurnals').val();
			jurnals        = JSON.parse(jurnals);
			var temp       = $('#temp').val();
			temp           = JSON.parse(temp);
			var transaksis = $('#transaksis').val();
			transaksis     = JSON.parse(transaksis);
			var periksa    = $('#periksa').val();
			periksa        = JSON.parse(periksa);

			var debit = 0;
			var kredit = 0;
			var total_harta_masuk = 0;
			 for (var i = 0; i < jurnals.length; i++) {
				 if( jurnals[i].debit == '1' ){
					debit += parseInt( jurnals[i].nilai );
				 } else {
					kredit += parseInt( jurnals[i].nilai );
				 }
				 if( jurnals[i].coa_id.substring(0,2) == '11' && jurnals[i].debit == '1' ){
					 total_harta_masuk += parseInt( jurnals[i].nilai );
				 }
			 }
			 for (var i = 0; i < temp.length; i++) {
				 if( temp[i].debit == '1' ){
					debit += parseInt( temp[i].nilai );
				 } else {
					kredit += parseInt( temp[i].nilai );
				 }
				 if( temp[i].coa_id.substring(0,2) == '11' && temp[i].debit == '1' ){
					 total_harta_masuk += parseInt( temp[i].nilai );
				 }
			 }
			var biaya = 0;
			 for (var i = 0; i < transaksis.length; i++) {
				biaya += parseInt( transaksis[i].biaya );
			 }
			var total_periksa = parseInt( periksa.tunai ) + parseInt( periksa.piutang );

		return {
			'kredit' : kredit,
			'debit' : debit,
			'biaya' : biaya,
			'total_periksa' : total_periksa,
			'total_harta_masuk' : total_harta_masuk
		};
	}
	function stringifyJurnal(data){
		 data = JSON.stringify(data);
		 $('#jurnals').val(data);
	}
	function delJurnal(control){
		var jurnals = $('#jurnals').val();
		jurnals = JSON.parse(jurnals);
		var i = $(control).closest('tr').find('.key').html();
		i = $.trim(i);
		jurnals.splice(i, 1);
		console.log(jurnals);
		jurnals = JSON.stringify(jurnals);
		$('#jurnals').val(jurnals);
		$(control).closest('tr').remove();
		var htg = hitung();
		callValue(htg);
		var rows = $('#table_template_jurnal tbody tr').length;
		console.log(rows);
		for (var i = 0, len = rows; i < len; i++) {
			$('#table_template_jurnal tbody tr:nth-child(' + parseInt(i + 1) + ')').find('.key').html(i);
		}
	}
	function callValue(htg) {
		// console.log('===============================================================');
		// console.log('kredit');
		// console.log(htg.kredit);
		// console.log('debit');
		// console.log(htg.debit);
		// console.log('biaya');
		// console.log(htg.biaya);
		// console.log('total_periksa');
		// console.log(htg.total_periksa);
		// console.log('total_harta_masuk');
		// console.log(htg.total_harta_masuk);
		// console.log('===============================================================');
	}
	function changeAsuransi(control){
		var asuransi_id          = $(control).val();
		var prev_asuransi_coa_id = $('#asuransi_coa_id').html();
		var periksa              = $('#periksa').val();
		periksa                  = JSON.parse(periksa);
		periksa['asuransi_id']   = asuransi_id;
		periksa                  = JSON.stringify(periksa);
		$('#periksa').val(periksa)
		$.get(base + '/asuransis/get/coa_id',
			{ asuransi_id: asuransi_id },
			function (data, textStatus, jqXHR) {
				data = $.trim(data);
				$('.name_111').find('select').val(data);
				$('.name_111').find('select').selectpicker('refresh');
				coaChange($('.name_111').find('select'));
			}
		);


	}
	function updatePeriksa(nilai, tipe) {
		var periksa   = $('#periksa').val();
		periksa       = JSON.parse(periksa);
		periksa[tipe] = nilai;
		periksa       = JSON.stringify(periksa);
		$('#periksa').val(periksa);
	}
	function getKey(temp) {
		var key = '';
		for (let i = 0, len = temp.length; i < len; i++) {
			if (temp[i].coa_id.substring(0,3) == '110') {
				key = i;
				break;
			}
		}
		return key;
	}

