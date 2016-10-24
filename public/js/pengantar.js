
		var arr = $('#jsonArray').val();
		arr = JSON.parse(arr);
		view(arr);
	
	function view(data){
		var temp = '';
		var tempForm = $('#tempForm').html();
		var tempKTP = $('#tempKTP').html();
		if(data.length > 0){

			for (var i = 0; i < data.length; i++) {
				temp += '<tr>';
				temp += '<td>' + data[i].nama +  '<br />';
				if( data[i].asuransi_id == '32' ){
					temp +=	'<strong>Nomor Asuransi :' + data[i].nomor_asuransi + '</strong>'
				}
				temp += '</td>';

				if( data[i].kartu_bpjs == null || data[i].kartu_bpjs == '' || data[i].kartu_bpjs == 'null' ){
					temp += '<td>' + tempForm + '</td>';
				}else{
					temp += '<td><img class="img-rounded upload" src="' + base + '/' + data[i].kartu_bpjs + '"/></td>';
				}

				if( data[i].ktp == null || data[i].ktp == '' ||data[i].ktp == 'null' ){
					temp += '<td>' + tempKTP + '</td>';
				}else{
					temp += '<td><img class="img-rounded upload" src="' + base + '/' + data[i].ktp + '"/></td>';
				}

				temp += '<td> <button class="btn btn-xs btn-danger" type="button" onclick="rowdel(this);return false;" value="'+i+'">delete</button> </td>';
				temp += '</tr>';
			}

		} else{
			temp += '<tr>';
			temp += '<td colspan="4" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>';
			temp += '</tr>';
		}

		$('#viewJson').html(temp);
		$('#jsonArray').val(JSON.stringify(data));
		imgError();

		$("input[type='file']").off('change', function(){
			readURL(this);
		});

		$("input[type='file']").on('change', function(){
			readURL(this);
		});
	}
	function rowdel(control){
		var arr = $('#jsonArray').val();
		arr = JSON.parse(arr);
		var i = $(control).val();
		arr.splice(i, 1);
		view(arr);
	}
	function dummyButton(){
		$('#submit').click();
	}
	
	function pasiensCreate(){
		var param = $('#pengantar_pasien_create').serializeArray();
		$.post(base + '/antrianpolis/pengantar/pasien/create/ajax', param, function(data) {
			data = JSON.parse(data);
			if (data.confirm == '1') {
				var previous = $('#jsonArray').val();
				previous = JSON.parse(previous);
				previous[previous.length] = {
					'id' : data.insert.pasien_id,
					'nama' : data.insert.nama,
					'ktp' : 'null',
					'asuransi_id' : '32',
					'nomor_asuransi' : data.insert.nomor_asuransi,
					'kartu_bpjs' : 'null',
					'kunjungan_sehat'	: '1'
				};
				view(previous);
				aktifkanTabCariPasien();
				moveScreenTo("#table_pengantar tr:first-child");
				alert('pasien ' + data.insert.nama + ' berhasil ditambahkan di Database, dan sudah masuk ke dalam daftar pengantar pasien')
			}
		});
	}

	function aktifkanTabCariPasien(){
		$('#tabCariPasien').tab('show');
		$('#pengantar_pasien_create').find('input', 'textarea','select' ).val('');
	}

	function fokuskanKeTabelUpdated(){
		 $('#table_pengantar').focus();
	}

	function moveScreenTo(element) {
		$("body").scrollTop($(element).offset().top);
	}
	
