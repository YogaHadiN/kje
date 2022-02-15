		viewTelpon();
		viewAnak();
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
		function viewTelpon(){
			var telps = parseTelp();
			var temp = '';
			for (var i = 0; i < telps.length; i++) {
				temp += '<tr>';
				temp += '<td class="i hide">' + i + '</td>';
				temp += '<td>' + telps[i].jenis_telpon + '</td>';
				temp += '<td>' + telps[i].nomor_telpon + '</td>';
				temp += '<td>  <button type="button" class="btn btn-danger btn-sm btn-block" onclick="hapusTelp(this); return false;">hapus</button>  </td>';
				temp += '</tr>';
			}
			$('#body_telpon').html(temp);
		}
		function parseTelp(){
			var telps = $('#telps').val();
			if($.trim(telps) == ''){
				telps = '[]';
			}
			var telps = JSON.parse(telps)
			return telps;
		}
		function inputTelpon(control){
			var jenis_telpon_id = $(control).closest('tr').find('.jenis_telpon_id').val();
			var jenis_telpon = $(control).closest('tr').find('.jenis_telpon_id option:selected').text();
			var nomor_telpon = $(control).closest('tr').find('.nomor_telpon').val();
			var telps = parseTelp();
			console.log(telps);
			var newTelp = {
				'jenis_telpon_id' : jenis_telpon_id,
				'jenis_telpon' : jenis_telpon,
				'nomor_telpon' : nomor_telpon
			};

			telps.push(newTelp);
			telps = JSON.stringify(telps);
			$('#telps').val(telps);
			viewTelpon();
			$('.inp_tel').val('');
			$('#jenis_telpon_id').focus();
		}
		function hapusTelp(control){
			var i = $(control).closest('tr').find('.i').html();
			var telps = parseTelp();
			telps.splice(i,1);
			console.log(telps);
			telps = JSON.stringify(telps);
			$('#telps').val(telps);
			viewTelpon();
		}
		function viewAnak(){
			var anaks = parseAnak();
			var temp = '';
			for (var i = 0; i < anaks.length; i++) {
				temp += '<tr>';
				temp += '<td class="i hide">' + i + '</td>';
				temp += '<td>' + anaks[i].nama_anak + '</td>';
				temp += '<td> <button type="button" class="btn btn-danger btn-sm btn-block" onclick="hapusAnak(this); return false;">hapus</button> </td>';
				temp += '</tr>';
			}
			$('#body_anak').html(temp);
		}
		function parseAnak(){
			var anaks = $('#anaks').val();
			if($.trim(anaks) == ''){
				anaks = '[]';
			}
			anaks = JSON.parse(anaks);
			return anaks;
		}
		function inputAnak(control){
			var nama_anak = $(control).closest('tr').find('.nama_anak').val();
			var anaks = parseAnak();
			var newAnak = {
				'nama_anak' : nama_anak
			};
			anaks.push(newAnak);
			anaks = JSON.stringify(anaks);
			$('#anaks').val(anaks);
			viewAnak();
			$('.nama_anak').val('');
			$('#nama_anak').focus();
		}
		function hapusAnak(control){
			var i = $(control).closest('tr').find('.i').html();
			var anaks = parseAnak();
			anaks.splice(i,1);
			anaks = JSON.stringify(anaks);
			$('#anaks').val(anaks);
			viewAnak();
			$('.nama_anak').val('');
			$('#nama_anak').focus();
		}
