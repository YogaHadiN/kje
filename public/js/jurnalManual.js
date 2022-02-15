	function validateView(){
		var coa_id = $('#coa_id').val();
		var coa = $('#coa_id option:selected').text();
		var nilai = $('#nilai').val();
		var debit = $('#debit').val();
		var temp= parseTemp();
		if( 
			coa_id == '' ||
			nilai == '' ||
			debit == ''
		){
			if( coa_id == '' ){
				validasi1($('#coa_id'), 'Harus Diisi!!');
			}
			if( nilai == '' ){
				validasi1($('#nilai'), 'Harus Diisi!!');
			}
			if( debit == '' ){
				validasi1($('#debit'), 'Harus Diisi!!');
			}
			clear();
			return false;
		}
		view();
	}
	function view(){
		var coa_id = $('#coa_id').val();
		var coa = $('#coa_id option:selected').text();
		var nilai = $('#nilai').val();
		var debit = $('#debit').val();
		nilai = parseInt(cleanUang(nilai));
		var newElement = { 
			'coa':     coa,
			'coa_id':     coa_id,
			'nilai':      nilai,
			'debit':      debit
		};
		var temp = parseTemp();
		temp[temp.length] = newElement;
		render(temp);
		clear();
	}
	function clear(){
		var coa_id = $('#coa_id').val('').selectpicker('refresh');
		var nilai = $('#nilai').val('');
		var debit = $('#debit').val('');
		$('#coa_id').closest('div').find('.btn-white').focus();
	}
	function parseTemp(){
		var temp = $('#temp').val();
		return JSON.parse(temp);
	}
	function del(i){
		temp = parseTemp();
		temp.splice(i, 1);
		render(temp);
	}
	function render(temp){
		var table = '';
		if( temp.length > 0 ){
			for (var i = 0; i < temp.length; i++) {
				table += '<tr>';
				if( temp[i].debit == '1' ){
					table += '<td>';
				} else {
					table += '<td class="text-right">';
				}
				table += temp[i].coa +  '</td>';
				if( temp[i].debit == '1' ){
					table += '<td class="text-right">' + uang( temp[i].nilai ) + '</td>';
					table += '<td></td>';
				} else {
					table += '<td></td>';
					table += '<td class="text-right">' + uang( temp[i].nilai ) + '</td>';
				}
					table += '<td> <button class="btn btn-danger btn-xs btn-block" type="button" onclick="del(' + i + ')">Delete</button> </td>';
				table += '</tr>';
			}
		} else {
			table += '<tr>';
			table += '<td colspan="4" class="text-center"> Tidak ada Data Untuk Ditampilkan </td>';
			table += '</tr>';
		}
		$('#result').html(table);
		temp = JSON.stringify(temp);
		$('#temp').val(temp);
	}
