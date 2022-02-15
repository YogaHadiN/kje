


	temp = parseTemp();
	render(temp);
	function dummySubmit(control){

		var kredit            = hitung().kredit;
		var debit             = hitung().debit;
		var biaya             = hitung().biaya;
		var total_periksa     = hitung().total_periksa;
		var total_harta_masuk = hitung().total_harta_masuk;

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
		var nilai = cleanUang( $(control).val() );
		var key = $(control).attr('title');
		var jurnals = $('#jurnals').val();
		jurnals = JSON.parse(jurnals);
		jurnals[key]['biaya'] = nilai;
		jurnals = JSON.stringify(jurnals);
		$('#jurnlas').val(jurnals);
		$('#debit_total').html(hitung().debit);
		$('#kredit_total').html(hitung().kredit);
	}
	
	function periksaKeyUp(control, tipe){
		var nilai = cleanUang( $(control).val() );
		var periksa = $('#periksa').val();
		periksa = JSON.parse(periksa);
		periksa[tipe] = nilai;
		periksa = JSON.stringify(periksa);
		$('#periksa').val(periksa);
		$('#periksa_total').html(hitung().total_periksa);
	}
	function coaChange(control){
		 var key   = parseInt( $(control).closest('tr').find('.key').html() );
		var coa_id = $(control).val();
		var data = $('#jurnals').val();
		data = JSON.parse(data);
		 data[key]['coa_id'] = coa_id;
		 data = JSON.stringify(data);
		 $('#jurnals').val(data);
	}

	function nilaiKeyUp(control){
		 var key   = parseInt( $(control).closest('tr').find('.key').html() );
		var nilai = cleanUang( $(control).val() );
		var data = $('#jurnals').val();
		data = JSON.parse(data);
		 data[key]['nilai'] = parseInt( nilai );
		 data = JSON.stringify(data);
		 $('#jurnals').val(data);
	}
	function transaksiPeriksa(control){

		var nilai = cleanUang( $(control).val() );
		var key = $(control).attr('title');

		var transaksis = $('#transaksis').val();
		transaksis = JSON.parse(transaksis);
		transaksis[key].biaya = nilai;
		transaksis = JSON.stringify( transaksis );
		$('#transaksis').val(transaksis);
		$('#biaya_total').html(hitung().biaya);
	}
	function hitung(){
			var jurnals = $('#jurnals').val();
			jurnals = JSON.parse(jurnals);
			var temp = $('#temp').val();
			temp = JSON.parse(temp);
			var transaksis = $('#transaksis').val();
			transaksis = JSON.parse(transaksis);
			var periksa = $('#periksa').val();
			periksa = JSON.parse(periksa);

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

		var id = $(control).closest('tr').find('.id').html();

		 for (var i = 0; i < jurnals.length; i++) {
			if( jurnals[i].id == id ){
				break;
			}
		 }

		jurnals.splice(i, 1);
		jurnals = JSON.stringify(jurnals);
		$('#jurnals').val(jurnals);
		$(control).closest('tr').remove();

	}

