	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			@if(isset($update))
				<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
			@else
				<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
			@endif
			{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
		</div>
	</div>
<div class="row hide">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		{!! Form::textarea('tipe_tindakans', $tipe_tindakans, ['class' => 'form-control', 'id' => 'tipe_tindakans'])!!}
	</div>
</div>
<script type='text/javascript'>

function dummySubmit(control){
	console.log('this');
	if(validatePass2(control)){
		$('#submit').click();
	}
	console.log('sparta');
}

function kataKunciValid(control){
	if(control == ''){
		return true;
	}
	var result = true;
	$.get(base + '/asuransis/kata_kunci/unique_test',
		{ 
			kata_kunci: control,
			asuransi_id: $('#asuransi_id').val()
		},
		function (data, textStatus, jqXHR) {
			data = $.trim(data);
			result = data == '1'; 
		}
	);
	return result;
}
	var biaya = '';
	var dibayar_asuransi = '';
	var jasa_dokter = '';
	var tipe_tindakan = '';

	var tarifs = $('#tarifs').val();
	tarifs = $.parseJSON(tarifs);

	var temp = '';
	for (var i = 0; i < tarifs.length; i++) {
		temp += '<tr>';
		temp += '<td nowrap class="jenis_tarif">' + tarifs[i].jenis_tarif + '</td>';
		temp += '<td nowrap class="biaya">' + tarifs[i].biaya + '</td>';
		temp += '<td nowrap class="jasa_dokter">' + tarifs[i].jasa_dokter + '</td>';
		temp += '<td class="tipe_tindakan">' +  tarifs[i].tipe_tindakan + '</td>';
		temp += '<td class="action">' + '<button type="button" class="btn btn-warning" onclick="rowEdit(this); return false;" value="' +i+ '">edit</buttom>' + '</td>';
		temp += '<td nowrap class="hide id">' + tarifs[i].id + '</td>';
		temp += '<td class="hide tipe_tindakan_id">' + tarifs[i].tipe_tindakan_id + '</td>';
		temp += '</tr>';
	}

	$('#tblTarif').html(temp);
	</script>
	<script>
		function rowEdit(control){
			var index     = $(control).closest('tr').index() + 1;

			biaya         = $('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html();
			jasa_dokter   = $('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html();
			tipe_tindakan = $('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html();
			tipe_tindakan_id = $(control).closest('tr').find('.tipe_tindakan_id').html();

			var txtbiaya = '<div class="w"><input type="text" class="form-control" value="' +biaya+ '" id="txtbiaya" /></div>';
			var txtjasadokter = '<div class="w"><input type="text" class="form-control" value="' +jasa_dokter+ '" id="txtjasadokter"/></div>';
			var ddltipetindakan = ddlTipeTindakan(tipe_tindakan_id);

			var action = '';
			action += '<button type="button" class="btn btn-info btn-block" onclick="rowUpdate(this);return false;">Update</button>';
			action += '<button type="button" class="btn btn-danger btn-block" onclick="rowCancel(this);return false;">Cancel</button>';

			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html(txtbiaya);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html(txtjasadokter);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html(ddltipetindakan);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(action);

			$('#tblTarif tr:nth-child(' + index + ') input[type="text"]').on("click", function () {
				$(this).select();
			});

			$('#tblTarif tr:nth-child(' + index + ') #txtbiaya').click();

			$('.btn-warning').attr('disabled', 'disabled');

			$("#tblTarif .form-control").keydown(function (e) {
				console.log('masuk');
				// Allow: backspace, delete, tab, escape, enter and .
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) ||
					 // Allow: Ctrl+C
					(e.keyCode == 67 && e.ctrlKey === true) ||
					 // Allow: Ctrl+X
					(e.keyCode == 88 && e.ctrlKey === true) ||
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
				}
			});

		}
	</script>
	<script>
		function rowCancel(control){

			var index = $(control).closest('tr').index() + 1;

			$('.btn-warning').removeAttr('disabled');

			var key = $(control).val();

		  
			var htmaction = '<button type="button" class="btn btn-warning" onclick="rowEdit(this); return false;" value="' +key+ '">edit</buttom>';

			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html(biaya);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html(jasa_dokter);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html(tipe_tindakan);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(htmaction);

		}
		function rowUpdate(control){

			var key   = $(control).closest('tr').index();
			var index = key + 1;
			var id    = $('#tblTarif tr:nth-child(' + index + ') td:last-child').html();

			var biaya_update            = $('#txtbiaya').val();
			var jasa_dokter_update      = $('#txtjasadokter').val();
			var tipe_tindakan_update    = $('#ddltipetindakan option:selected').text();
			var tipe_tindakan_id_update = $('#ddltipetindakan').val();

			tarifs[key]['biaya'] = empty(biaya_update);
			tarifs[key]['jasa_dokter'] = empty(jasa_dokter_update);
			tarifs[key]['tipe_tindakan_id'] = tipe_tindakan_id_update;

			key = $(control).val();

			var htmaction = '<button type="button" class="btn btn-warning" onclick="rowEdit(this); return false;" value="' + key + '">edit</buttom>';
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(2)').html(empty(biaya_update));
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(3)').html(empty(jasa_dokter_update));
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(4)').html(tipe_tindakan_update);
			$(control).closest('tr').find('.tipe_tindakan_id').html(tipe_tindakan_id_update);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(htmaction);
			$('#tblTarif tr:nth-child(' + index + ') td:nth-child(5)').html(htmaction);

			$('#tarifs').val(JSON.stringify(tarifs));


			$('.btn-warning').removeAttr('disabled');

		}

		function empty(val){

			if (val == '') {
				val = '0';
			}

			return val
		}
		function functionName(fun) {
		  var ret = fun.toString();
		  ret = ret.substr('function '.length);
		  ret = ret.substr(0, ret.indexOf('('));
		  return ret;
		}
		function ddlTipeTindakan(val){
			var tipe_tindakans = $('#tipe_tindakans').val();
			var tipe_tindakans = $.parseJSON(tipe_tindakans); 
			console.log('val');
			console.log(val);
			var temp  = '<select class="form-control" id="ddltipetindakan">';
			for (var i = 0; i < tipe_tindakans.length; i++) {
				temp += '<option value="' + tipe_tindakans[i].id + '"' ;
				if(val == tipe_tindakans[i].id){
					temp += ' selected';
				}
				temp += '>';
				temp +=  tipe_tindakans[i].tipe_tindakan + '</option>';
			}
			temp += '</select>' ;
			return temp;
		}

	</script>
