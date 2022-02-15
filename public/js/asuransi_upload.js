$(':file').on('change', function () {
	var asuransi_id = $('#asuransi_id').val();
	var models = $('#models').val();
	var folder = $('#folder').val();
	  var file = this.files[0];
	  if (file.size > 10485760) {
		alert('File paling besar untuk di upload adalah 10 MB');
		$(this).val('');
	  } else if( $('#nama_file').val() == '' ) {
		alert('Peruntukan berkas harus diisi!');
		$(this).val('');
	  } else {
		  var ajax_data = {
				'asuransi_id': asuransi_id,
				'file':        $('#file').prop('files'),
				'nama_file':   $('#nama_file').val()
			};
		$.ajax({
			// Your server script to process the upload
			url: base + '/' + models + '/' + asuransi_id + '/upload',
			type: 'post',

			// Form data
			data: new FormData($('form')[0]),

			// Tell jQuery not to process data or worry about content-type
			// You *must* include these options!
			cache: false,
			contentType: false,
			processData: false,

			// Custom XMLHttpRequest
			xhr: function () {
			  var myXhr = $.ajaxSettings.xhr();
			  if (myXhr.upload) {
				// For handling the progress of the upload
				myXhr.upload.addEventListener('progress', function (e) {
				  if (e.lengthComputable) {
					  var persen= e.loaded / e.total *100;
					$('#progress').attr({
					  'aria-valuenow': persen,
					  'style': 'width:' + persen + '%'
					});
					$('#progress').html(String(Math.floor(persen)) + ' %');
				  }
				}, false);
			  }
			  return myXhr;
			},
			success: function (data, textStatus, jqXHR) {
				var color = [
					'primary',
					'info',
					'warning',
					'danger'
				];
				var random_number = Math.floor(Math.random() * 4);
				console.log(random_number);
				var html = '<tr>';
				html += '<td>';
				html += '<a class="btn btn-' + color[random_number]  + ' btn-block" href="' + base + '/berkas/' + folder + '/' + asuransi_id + '/' + data + '.pdf" target="_blank">Download ' + $('#nama_file').val() + '</a>';
				html += '</td><td nowrap class="autofit">';
				html += '<button type="button" onclick="deleteBerkas(' + data + ', this); return false;" class="btn btn-danger"> <i class="glyphicon glyphicon-remove"></i> </button>'
				html += '</td>';
				html += '</tr>';
				$('#download_container').append(html);
				$('#nama_file').val('');
				$(this).val('');
			}
		  });
	  }
});
function deleteBerkas(id, control){
	if( confirm( "Anda yakin mau menghapus berkas ini?" ) ){
		$.post( base + '/asuransis/berkas/hapus',
			{ berkas_id: id },
			function (data, textStatus, jqXHR) {
				if( parseInt(data) > 0 ){
					$(control).closest('tr').remove();
				} else {
					alert('menghapus gagal');
				}
			}
		);
	}
}
