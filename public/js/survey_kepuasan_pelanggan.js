function survey(index) {
	var surveyable_id   = $('#surveyable_id').val()
	var surveyable_type = $('#surveyable_type').val()
	if ( surveyable_id != '' ) {
		$.get(base + '/survey/kepuasan/pelanggan',
			{
				surveyable_id:   surveyable_id,
				surveyable_type: surveyable_type,
				index:           index
			},
			function (data, textStatus, jqXHR) {
				var data = $.trim( parseInt(data));
				console.log(index);
				if (data > 0) {
					if ( index == '2')  {
						Swal.fire({
						  icon: 'success',
						  title: 'Terima Kasih',
						  text: 'Terima kasih atas respon baik anda Mohon agar dapat Memberikan Review Baik Anda di Google Review',
						  imageUrl: base_s3 + '/img/google_review.png',
						  imageWidth: 400,
						  imageAlt: 'Custom image',
						  showConfirmButton: false,
						  timer: 5000
						});
					} else {
						Swal.fire({
						  icon: 'success',
						  title: 'Berhasil',
						  text: 'Terima kasih atas masukan Anda',
						  showConfirmButton: false,
						  timer: 5000
						});
					}
				}
			}
		);
	} else {
		error();
	}
	$('#surveyable_id').val('');
	$('#surveyable_type').val('');
}

function error(){
	Swal.fire({
	  icon: 'error',
	  title: 'Oops...',
	  text: 'Ada kesalahan',
	  showConfirmButton: false,
	  timer: 1500
	});
}
