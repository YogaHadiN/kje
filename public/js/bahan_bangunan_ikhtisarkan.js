$('.temp').val('[]');
function dummySubmit(){
	var sama             = false;
	var keterangan_false = [];
	$('.temp').each(function(){
		sama = true;
		var pg_id      = $.trim( $(this).closest('.panel').find('.pg_id').html() );
		var nilai      = $.trim( $(this).closest('.panel').find('.nilai').html() );
		var keterangan = $.trim( $(this).closest('.panel').find('.keterangan').html() );
		var temp       = parseTemp(this);
		var total_harga = 0
		for (var i = 0; i < temp.length; i++) {
			total_harga += parseInt( temp[i].harga_satuan ) * parseInt( temp[i].jumlah );
		}
		if( parseInt( total_harga ) != parseInt( nilai ) ){
			sama = false;
			keterangan_false.push( keterangan + ' Harga di Nota = ' + uang(nilai) + ' Harga di peralatan = ' + uang(total_harga) + ' ada selisih sebesar ' + uang( Math.abs(nilai - total_harga) ) );
		}
	});
	console.log(keterangan_false);
	if( sama == false ){
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text:'nilai tidak sama pada pengeluaran dengan pg_id '
		});
		var text = '<p>Antara nilai yang diinput di peralatan dan harga di nota tidak sama pada pengeluaran dengan keterangan : </p>';
		text += '<ul>';
		 for (var i = 0; i < keterangan_false.length; i++) {
			text += '<li>' +keterangan_false[i]+ '</li>';
		 }
		text += '</ul>';
		$('#danger_row').show();
		$('#danger_alert').html(text);
		return false;
	}
	if( validatePass() ){
		$('#submit').click();
	}
}
function inp(control){

	var datas = tempData(control);

	console.log(datas);

	var pg_id          = datas.pg_id;
	var sumber_uang_id = datas.sumber_uang_id;
	var tanggal        = datas.tanggal;
	var staf_id        = datas.staf_id;
	var supplier_id    = datas.supplier_id;
	var faktur_image   = datas.faktur_image;
	var created_at     = datas.created_at;
	var temp           = datas.temp;

	var keterangan    = $(control).closest('tr').find('.keterangan').val();
	var harga_satuan  = cleanUang( $(control).closest('tr').find('.harga_satuan').val() );
	var jumlah        = $(control).closest('tr').find('.jumlah').val();

	temp[temp.length]= {
		'pg_id':          pg_id,
		'keterangan':     keterangan,
		'harga_satuan':   harga_satuan,
		'sumber_uang_id': sumber_uang_id,
		'staf_id':        staf_id,
		'tanggal':        tanggal,
		'faktur_image':   faktur_image,
		'supplier_id':    supplier_id,
		'created_at':     created_at,
		'jumlah':         jumlah
	}
	$(control).closest('table').find('.keterangan').focus();
	stringify(temp, control);
}
function view(control){
	var temp = parseTemp(control);
	var arr = '';
	var uangTotal = 0;
	if( temp.length > 0 ){
		 for (var i = 0; i < temp.length; i++) {
			uangTotal += parseInt(temp[i].harga_satuan) * parseInt(temp[i].jumlah);
			arr       += '<tr>';
			arr       += '<td>' + temp[i].keterangan+ '</td>';
			arr       += '<td class="uang text-right">' + temp[i].harga_satuan+ '</td>';
			arr       += '<td class="text-right">' + temp[i].jumlah+ '</td>';
			arr       += '<td> <button value="' +i+'" class="btn btn-danger btn-xs btn-block" type="button" onclick="rowDel(this);return false;">delete</button> </td>';
		 }
		arr += '</tr>';
	}
	var nilai = $(control).closest('.panel').find('.nilai').html();
	$(control).closest('.panel-info').find('.uang_total').html( uang( uangTotal ) );
	$(control).closest('.panel-info').find('.info_uang_sama')
		.removeClass('alert')
		.removeClass('alert-danger')
		.removeClass('alert-primary');
	if( nilai == uangTotal ){
		$(control).closest('.panel-info').find('.info_uang_sama').find('i').html('Nilai Sama');
		$(control).closest('.panel-info').find('.info_uang_sama').addClass('alert alert-success');
	} else {
		$(control).closest('.panel-info').find('.info_uang_sama').addClass('alert alert-danger');
		$(control).closest('.panel-info').find('.info_uang_sama').find('i').html('Nilai Belum Sama');
	}
	$(control).closest('table').find('tbody').html(arr);
	formatUang();
}
	
