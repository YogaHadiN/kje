getData();
function getData(){
	var nama_asuransi = $('#nama_asuransi').val();
	var invoice_id    = $('#invoice_id').val();
	var tanggal       = $('#tanggal').val();
	var piutang       = $('#piutang').val();
	var sudah_dibayar = $('#sudah_dibayar').val();
	var sisa          = $('#sisa').val();

	$.get('/invoices/getData',
		{
			 nama_asuransi: nama_asuransi,
			 tanggal:       tanggal,
			 piutang:       piutang,
			 sudah_dibayar: sudah_dibayar,
			 sisa:          sisa,
			 invoice_id:    invoice_id
		},
		function (data, textStatus, jqXHR) {
			var temp = '';

			for (let i = 0, len = data.length; i < len; i++) {
				var sudah_dibayar = 0;
				if (data[i].sudah_dibayar !== null) {
					sudah_dibayar = data[i].sudah_dibayar;
				}
				temp +='<tr>'
				temp +='<td nowrap>'
				temp += data[i].tanggal
				temp +='</td>'
				temp +='<td nowrap>'
				temp += data[i].invoice_id
				temp +='</td>'
				temp +='<td nowrap>'
				temp += data[i].nama_asuransi
				temp +='</td>'
				temp +='<td class="uang">'
				temp += data[i].piutang
				temp +='</td>'
				temp +='<td class="uang">'
				temp += sudah_dibayar
				temp +='</td>'
				temp +='<td class="uang">'
				temp +=  data[i].piutang - data[i].sudah_dibayar
				temp +='</td>'
				temp +='<td nowrap>'
				temp += '<a class="btn btn-info btn-sm" href="' + base + '/invoices/' + data[i].invoice_id.replace(/\//g, '!') + '" target="_blank">Show</a>'
				temp +='</td>'
				temp +='</tr>'
			}
			$('#invoices_data').html(temp);
			$('#invoices_data').find('.uang').each(function() {
				var content = $(this).html();
				if (content == null) {
					return '';
				}
				var number = content;
				number = number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
				number = 'Rp. ' + number.trim();
				$(this).html(number);
			});
		}
	);
}
