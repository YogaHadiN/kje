function tambahGambar(){
    $('#LinkButton2').off('click', function () {
		validasiKeterangan();
	});
	var temp = $('#container_image').html();	 
	$('#panel_gambar').append(temp);

	$("input[type='file']").off('change', function(){
		temporaryImage(this);
	});
	$("input[type='file']").on('change', function(){
		temporaryImage(this);
	});
    $('#LinkButton2').on('click', function () {
		validasiKeterangan();
	});
}
function hapusGambar(control){
	 $(control).closest('.inputGambar').remove();
}
function temporaryImage(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$(input).closest('.inputGambar').find('img').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
function validasiKeterangan(){
	if ( $('#poli_id').val() == 'estetika' ) {
		var pesan = 'Harus Diisi!';
		var result = true;
		$('form .required').each(function(){
			if ( $(this).val() == '' || $(this).val() == null ) {
				$(this).focus();
				alert('payaaaaa');
				return false;
				$(this).parent()
				.find('code')
				.remove();

				$(this).parent()
				.addClass('has-error')
				.append('<code>' + pesan + '</code>');

				$(this).parent()
				.find('code')
				.hide()
				.fadeIn(1000);

			   $(this).on('keyup change', function(){
				  $(this).parent()
				  .removeClass('has-error')
				  .find('code')
				  .fadeOut('1000', function() {
					  $(this).remove();
				  });
			   });
				result = false;
			}
		});
		if (!result) {
			alert('Keterangan Gambar Harus Diisi');
			$('#tab-status').tab('show');
			$('.required:first').focus();
		} else {
			dummySubmit();
		}
	} else {
		dummySubmit();
	}
}

