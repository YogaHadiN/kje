        function rowEntry(control) {
			var id = $(control).closest('tr').find('td:first-child').find('div').html();
			var nama = $(control).closest('tr').find('td:nth-child(2)').find('div').html();
			var image = $(control).closest('tr').find('td:nth-child(12)').find('div').html();

			var MyArray = $('#jsonArray').val();
			MyArray = JSON.parse(MyArray);
			
			//Pastikan tidak ada pasien yang sama yang dimasukkan dalam daftar pengantar
			//
			//
			
			var sama = false;
			for (var i = 0, l = MyArray.length; i < l; i++) {
				if (MyArray[i].id == id) {
					sama = true;
					break;
				}
			}
			if (sama) {
				//Bila sama gagalkan input, karena percuma input 2 kali di pemeriksaan yang sama
				alert('Tidak bisa dimasukkan, karena ' + id + '-' + nama + ' sudah ada di daftar pengantar' );
				return false;
			}

			var r = confirm('Anda akan memasukkan ' + id + ' - ' + nama + ' sebagai pengantar')	;
			if (r) {

				$.post(base + '/antrianpolis/get/kartubpjs', {'pasien_id' : id}, function(data) {
					data = $.trim(data);
					data = JSON.parse(data);
					if (data.confirmSudah == '1') {
						var kunjungan_sehat = '0';
					} else {
						var kunjungan_sehat = '1';
					}

					var arr = $('#jsonArray').val();
					arr = JSON.parse(arr);
					arr[arr.length] = {
						'id'				: id,
						'nama'				: nama,
						'ktp'				: data.ktp_image,
						'asuransi_id'		: data.asuransi_id,
						'nomor_asuransi'	: data.nomor_asuransi,
						'kartu_bpjs'		: data.bpjs_image,
						'kunjungan_sehat'	: kunjungan_sehat
					};
					view(arr);
				});
			}
        }
