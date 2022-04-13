function alasas_hapus(control){
	var id = $(control).closest('tr').find('.antrian_periksa_id').html()
	var pasien_id = $(control).closest('tr').find('.pasien_id').html()
	var nama_pasien = $(control).closest('tr').find('.nama_pasien').html()
	var onclick = 'modalAlasan(this' + ', "' + pasien_id + '", "' + nama_pasien + '"); return false;';

	$('#modal-alasan .id').val(id);
	$('#modal-alasan .pasien_id').val(pasien_id);
	$('#modal-alasan').modal('show');
	$('#modal-alasan .dummySubmit').attr('onclick', onclick);
}

function hapusSajalah(){
	var id = $('#alasan_id').val();
	var submit_id = $('#submit_id').val();
	console.log('id = ' + id);
	$('#' + id).val($('#alasan_textarea').val());
	$('#' + submit_id).click();
}

function cekMasihAda(control, periksa_id){
	$.post( base + '/antrianperiksas/ajax/cekada', 
		{'periksa_id': periksa_id }, 
		function(data) {
			data = $.trim(data);
			if (data == '1') {
				var text = $(control).closest('span').find('.hide').html();
				$(control).closest('span').find('.hide').get(0).click();
			} else {
				Swal.fire({
				  icon: 'error',
				  title: 'Oops...',
				  text:'pasien sudah pulang'
				});
				location.reload();
			}
	});
}
function changePoli(control){
	if( $(control).val() != '' ){
		$(control).closest('form').submit();
	}
}
function changeStaf(control){
	var staf_id            = $(control).val();
	var antrian_periksa_id = $(control).closest('tr').find('.antrian_periksa_id').html();


	$.post(base + '/antrianperiksas/update/staf',
		{ 
			staf_id: staf_id ,
			antrian_periksa_id: antrian_periksa_id
		},
		function (data, textStatus, jqXHR) {
			console.log(data);
		}
	);
}

