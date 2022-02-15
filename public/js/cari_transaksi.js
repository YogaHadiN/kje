var timeout;
$("body").on('keyup', '.parameter', function () {
	var colspan = $('#table_cari_transaksi').find('thead tr').find('th:not(.displayNone)').length;
	$('#table_cari_transaksi tbody').html(
		"<tr><td colspan='" +colspan+ "'><img class='loader' src='" +base_s3+ "/img/loader.gif' /></td></tr>"
	)
	window.clearTimeout(timeout);
	timeout = window.setTimeout(function(){
		refreshTransaksi();
	},600);
});
function refreshTransaksi() {
	var table         = $('#table_cari_transaksi')
	var tanggal   = table.find('.tanggal').val();
	var nama_pasien   = table.find('.nama_pasien').val();
	var nama_asuransi = table.find('.nama_asuransi').val();
	var tunai         = table.find('.tunai').val();
	var piutang       = table.find('.piutang').val();
	var sudah_dibayar = table.find('.sudah_dibayar').val();

	var param = {
		'tanggal':         tanggal,
		'nama_pasien':   nama_pasien,
		'nama_asuransi': nama_asuransi,
		'tunai':         tunai,
		'piutang':       piutang,
		'sudah_dibayar': sudah_dibayar
	};
	console.log('param');
	console.log(param);

	$.get( base + '/laporans/periksas/cari_transaksi',
		param,
		function (data, textStatus, jqXHR) {
			var temp = '';
			for (let i = 0, len = data.length; i < len; i++) {
				temp += '<tr>'
				temp += '<td><a target="_blank" href="' + base + '/periksas/' + data[i].periksa_id + '">' + data[i].tanggal+ '</a></td>'
				temp += '<td><a target="_blank" href="' + base + '/pasiens/' + data[i].pasien_id + '/transaksi">' + data[i].nama_pasien+ '</a></td>'
				temp += '<td>' + data[i].nama_asuransi+ '</td>'
				temp += '<td class="uang">' + data[i].tunai+ '</td>'
				temp += '<td class="uang">' + data[i].piutang+ '</td>'
				temp += '<td class="uang">' + data[i].sudah_dibayar+ '</td>'
				temp += '</tr>'
			}
			$('#transaksi_container').html(temp);
			table.find('.uang').each(function() {
				var number = $(this).html();
				number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
				$(this).html('Rp. ' + number.trim() + ',-');
			});
		}
	);





}
