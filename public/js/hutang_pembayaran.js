var timeout;
var orderBy = { 
	'column_name' : 'tanggal_dibayar',
	'order' : 'desc'
};
$("body").on('keyup', '.ajaxGetPembayaran', function () {
	var colspan = $('#table_pembayaran_asuransi').find('thead tr').find('th:not(.displayNone)').length;
	$('#container_pembayaran_asuransi').html(
		"<td colspan='" +colspan+ "'><img class='loader' src='" +base_s3+ "/img/loader.gif' /></td>"
	)
	window.clearTimeout(timeout);
	timeout = window.setTimeout(function(){
		refreshPembayaran();
	},600);
});

$("body").on('change', '#displayed_rows_pembayaran', function () {
	var colspan = $('#table_pembayaran_asuransi').find('thead tr').find('th:not(.displayNone)').length;
	$('#container_pembayaran_asuransi').html(
		"<td colspan='" +colspan+ "'><img class='loader' src='" +base_s3+ "/img/loader.gif' /></td>"
	)
	window.clearTimeout(timeout);
	timeout = window.setTimeout(function(){
		refreshPembayaran();
	},600);
});

var timeout;
$("body").on('click', '.getOrderPembayaran', function () {

	var column_name = $(this).data('column-name');
	var order       = $(this).data('order');

	orderBy = {
		column_name: column_name,
		order:       order
	};

	var colspan     = $('#table_pembayaran_asuransi').find('thead tr').find('th:not(.displayNone)').length;
	$('#container_pembayaran_asuransi').html(
		"<td colspan='" +colspan+ "'><img class='loader' src='" +base_s3+ "/img/loader.gif' /></td>"
	)
	window.clearTimeout(timeout);
	timeout = window.setTimeout(function(){
		refreshPembayaran();
	},600);
});



function refreshPembayaran(key = 0){
	if($('#pagination-pembayaran').data("twbs-pagination")){
		$('#pagination-pembayaran').twbsPagination('destroy');
	}
	getPembayaran(key);
}
  function getPembayaran(key = 0){

	  var displayed_rows = $('#table_pembayaran_asuransi').closest('.panel-body').find('.displayed_rows').val();
	  var param = { 
		  'pembayaran_asuransi_id ': $('#table_pembayaran_asuransi').find('.id').first().val(),
		  'tanggal':                 $('#table_pembayaran_asuransi').find('.tanggal_dibayar').first().val(),
		  'displayed_rows':          displayed_rows,
		  'pembayaran':              $('#table_pembayaran_asuransi').find('.pembayaran').first().val(),
		  'nilai':                   $('#table_pembayaran_asuransi').find('.nilai').first().val(),
		  'selisih':                 $('#table_pembayaran_asuransi').find('.selisih').first().val(),
		  'deskripsi':               $('#table_pembayaran_asuransi').find('.deskripsi').first().val(),
		  'column_name':             orderBy['column_name'],
		  'order':                   orderBy['order'],
	  	  'key':                     key
	  };
	  $.get(base + '/asuransis/riwayat/pembayaran/' + $('#asuransi_id').val(), param, function(data) {
		  var temp       = '';
		  var total_rows = data.total_rows;
		  var data       = data.data;
		  console.log('data');
		  console.log(data);
			for (let i = 0, len = data.length; i < len; i++) {
				var selisih = parseInt(data[i].pembayaran) - parseInt(data[i].nilai);
				// var tanggal = data[i].tanggal_dibayar == null ? '-': Date.parse(data[i].tanggal).toString("yyyy-MM-dd");
				temp += '<tr>';
				temp += '<td nowrap>' + data[i].pembayaran_asuransi_id + '</td>';
				temp += '<td nowrap>' + data[i].tanggal_dibayar + '</td>';
				temp += '<td class="uang" nowrap>' + data[i].pembayaran + '</td>';
				temp += '<td class="uang" nowrap>' + data[i].nilai + '</td>';
				temp += '<td class="uang" nowrap>' + selisih + '</td>';
				temp += '<td class="deskripsi">' + data[i].deskripsi + '</td>';
				temp += '</tr>';
			}
		  $('#container_pembayaran_asuransi').html(temp);
		  $('#container_pembayaran_asuransi').find('.uang').each(function(){
			  if (
				 $(this).html() == 'null' ||
				 $(this).html() == 'NaN'
			  ) {
				  $(this).html('-');
			  } else {
				  var money = uang( $(this).html() )
				  $(this).html(money);
			  }
		  });
		  $('#container_pembayaran_asuransi').find('.deskripsi').each(function(){
			  if (
				 $(this).html() == 'null' ||
				 $(this).html() == 'NaN'
			  ) {
				  $(this).html('-');
			  }
		  });
		  $('.getOrderPembayaran').each(function() {
			  var caret = '';
			  var newOrder = 'desc';
			  if ( !($(this).data('column-name') == orderBy['column_name'])) {
				  $(this).find('i').remove();
			  } else {
				  if ( 
					  orderBy['order'] == 'asc' ||
					  orderBy['order'] == 'no'
				  ) {
				  	caret = '<i class="fas fa-caret-down"></i>'
					newOrder = 'desc';
				  } else {
				  	caret = '<i class="fas fa-caret-up"></i>'
					newOrder = 'asc';
				  }
				  $(this).find('i').remove();
				  $(this).append(caret);
				  $(this).data('order', newOrder);
			  }
		  });
		  var visible_pages = 7;
		  var total_pages = Math.ceil(total_rows / displayed_rows);
		  $('#pagination_pembayaran_asuransi').twbsPagination({
				startPage: parseInt(key) +1,
				totalPages: total_pages,
				visiblePages: visible_pages,
				onPageClick: function (event, page) {
					getPembayaran(parseInt( page ) -1);
				}
			});
	  });
  }

