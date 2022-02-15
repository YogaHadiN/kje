	var akun_oke = false;
	var temp_coa_id = '';

	$(function () {
		kelompok_coa_change();
		if ( $('#kode_coa').val().length == 6) {
			temp_coa_id = $('#kode_coa').val() ;
		}
	});
	function kelompok_coa_change(){
		var kelompok_coa_id = $('#kelompok_coa_id').val();
		if(kelompok_coa_id != ''){
			$('#kode_coa')
				.val(kelompok_coa_id)
				.removeAttr('disabled');
		} else {
			$('#kode_coa')
				.val( '' )
				.prop('disabled', 'disabled');
		}
	}

	function kode_coa_keyup(){
		var kode_coa_id = $('#kode_coa').val();
		var kelompok_coa_id = $('#kelompok_coa_id').val();
		var arr = kode_coa_id.split('');
		 if(kelompok_coa_id.length == 1){
			 if(arr[0] != kelompok_coa_id){
				 $('#kode_coa').val(kelompok_coa_id);
			 }
		 }
		 if(kelompok_coa_id.length == 2){
			 if(arr[0] + arr[1] != kelompok_coa_id){
				 $('#kode_coa').val(kelompok_coa_id);
			 }
		 }

		if ( $('#kode_coa').val().length == 6 ) {

			 $.post(base + '/coas/cek_coa_sama',
				{
				   	'kode_coa_id': $('#kode_coa').val()
				},
				function (data) {
					data = $.trim(data);
					if(data == '1'){
						$('#kode_coa').closest('div')
							.append('<code>Sudah Ada Kode Akun Yang Sama</code>')
							.addClass('has-error');
						akun_oke = false;
						$('#keterangan_coa')
							.val('')
							.prop('disabled', 'disabled');
					} else {
						akun_oke = true;
						$('#keterangan_coa').removeAttr('disabled');
					}
				}
			 );
			 temp_coa_id = $('#kode_coa').val()
			
		} else if( $('#kode_coa').val().length > 6 ){
			 $('#kode_coa').val(temp_coa_id)
		}else if( $('#kode_coa').val().length < 6 ){
			 $('#keterangan_coa').val('').prop('disabled', 'disabled')
		}


	}
	function submitCoa(control){
		 if(validatePass2(control)){
			$(control).closest('form').find('.submit').click();
		 }
	}




 
