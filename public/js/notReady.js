function parseTemp(control){
	var temp = $(control).closest('.panel').find('.temp').val();
	return JSON.parse(temp);
}
function stringify(temp, control){
	temp = JSON.stringify(temp);
	$(control).closest('.panel').find('.temp').val(temp);
	view(control);
	$(control).closest('table').find('.form-control').val('');
	$(control).closest('table').find('.peralatan').focus();
}
function rowDel(control){
	var temp = parseTemp(control);
	var key = $(control).val();
	temp.splice(key, 1);
	stringify(temp, control)
}
function tempData(control){
	var pg_id           = $.trim( $(control).closest('.panel').find('.pg_id').html() );
	var sumber_uang_id  = $.trim( $(control).closest('.panel').find('.sumber_uang_id').html() );
	var tanggal         = $.trim( $(control).closest('.panel').find('.tanggal-db').html() );
	var staf_id         = $.trim( $(control).closest('.panel').find('.staf_id').html() );
	var supplier_id     = $.trim( $(control).closest('.panel').find('.supplier_id').html() );
	var faktur_image     = $.trim( $(control).closest('.panel').find('.faktur_image').html() );
	var created_at      = $.trim( $(control).closest('.panel').find('.created_at').html() );
	var temp            = parseTemp(control);

	return {
		'pg_id':  pg_id,
		'sumber_uang_id': sumber_uang_id,
		'tanggal':  tanggal,
		'staf_id':  staf_id,
		'supplier_id':  supplier_id,
		'faktur_image': faktur_image,
		'created_at':  created_at,
		'temp':  temp
	};
}
