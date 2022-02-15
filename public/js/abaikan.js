search();
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var timeout;
var length = $("#rek_container").closest('table').find('thead').find('th').length;
function clearAndSearch(key = 0){
	$("#rek_container").html("<tr><td colspan='" +length + "' class='text-center'><img class='loader' src='" + base_s3 + "/img/loader.gif'></td></tr>");
	window.clearTimeout(timeout);
	timeout = window.setTimeout(function(){
		if($('#paging').data("twbs-pagination")){
			$('#paging').twbsPagination('destroy');
		}
		search(key);
	},600);
}
function search(key = 0){
	var pages;
	 $.get(base + '/rekening_bank/ignoredList/ajax',
		{ 
			'tanggal':         $('#tanggal').val(),
			'akun_bank_id':    $('#akun_bank_id').val(),
			'deskripsi':       $('#deskripsi').val(),
			'pembayaran_null': $('#pembayaran_null').val(),
			'displayed_rows':  $('#displayed_rows').val(),
			'key':             key
		},
		function (data, textStatus, jqXHR) {
			{{-- $('#paging').html(''); --}}
			var temp = '';
			for (var i = 0; i < data.data.length; i++) {
				temp += '<tr';
				if( data.data[i].pembayaran_asuransi_id ){
					temp += ' class="success"';
				}
				temp +='>';
				temp += '<td nowrap class="kolom_1">';
				temp += data.data[i].id;
				temp += '</td>';
				temp += '<td nowrap class="kolom_2">';
				temp += data.data[i].tanggal;
				temp += '</td>';
				temp += '<td class="kolom_3">';
				temp += data.data[i].deskripsi;
				temp += '</td>';
				temp += '<td class="text-right kolom_4" nowrap>';
				temp += uang(data.data[i].nilai);
				temp += '</td>';
				if( data.data[i].pembayaran_asuransi_id ){
					temp += '<td colspan="2" class="kolom_4" nowrap>';
						temp += '<button type="button" class="btn btn-warning btn-sm btn-block ">Detail</button>';
				} else {
					@if ( Auth::id() == 28 )
						temp += '<td class="fit-column kolom_4" nowrap>';
					@else
						temp += '<td colspan="2" class="fit-column kolom_4" nowrap>';
					@endif
					temp += '<a class="btn btn-primary btn-sm " href="' + base + '/pendapatans/pembayaran/asuransi/' + data.data[i].id+ '"><i class="fas fa-check"></i></a>';
					@if ( Auth::id() == 28 )
						temp += '</td>';
						temp += '<td class="fit-column">';
						temp += '<form method="POST" class="form-method" action="' + base + '/rekening_bank/ignore/' + data.data[i].id + '" accept-charset="UTF-8" class="m-t" role="form" enctype="multipart/form-data" autocomplete="off">';
						temp += '<input class="hide" name="_token" type="hidden" value="' + csrf_token + '">';
						temp += '<button class="btn btn-danger btn-sm " onclick="return confirm_click(this); return false;" type="button"><i class="fas fa-eye-slash"></i></button>';
						temp += '<button class="submit btn btn-danger btn-sm hide " type="submit"><i class="fas fa-eye-slash"></i></button>';
						temp += '</form>';
					@endif
				}
				temp += '</td>';
				temp += '</tr>';
			}
			$('#rek_container').html(temp);
			$('#rows').html(data.rows);
			pages = data.pages;
			$('#paging').twbsPagination({
				startPage: parseInt(key) +1,
				totalPages: pages,
				visiblePages: 7,
				onPageClick: function (event, page) {
					search(parseInt( page ) -1);
				}
			});
		}
	 );
}
function confirm_click(control){
	var deskripsi = $(control).closest('tr').find('.kolom_3').html();
	var nilai     = $(control).closest('tr').find('.kolom_4').html();
	alert('asuuuu');
	if(confirm("Anda yakin mau mengabaikan transaksi " + deskripsi + " senilai " + nilai)){
		$(control).closest('form').find('.submit').click();
	}			
}
