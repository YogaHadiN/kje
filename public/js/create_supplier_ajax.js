	$('#supplier_submit input[type="submit"]').click(function(){
		$.post('{{ url("suppliers") }}', {
					'nama' : $('#nama_supplier').val(),
					'alamat' : $('#alamat').val(),
					'hp_pic' : $('#hp_pic').val(),
					'no_telp' : $('#no_telp').val()
				}, function (data) {
				data = $.parseJSON(data);
				if(data.confirm == '1'){
					var options = data.options;
					var option = '';
					console.log(data.options);
					for (var i = 0; i < options.length; i++) {
						option += '<option value="' + options[i].value + '">' + options[i].text + '</option>';
					}

					console.log(option);
					$('#supplier_id').html(option).val(data.last_id).selectpicker('refresh');
					$('#create_supplier').modal('hide');
				}
			}
		);
	});
