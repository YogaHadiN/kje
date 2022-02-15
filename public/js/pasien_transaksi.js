getTransaksi();
function getTransaksi() {
	var nama_asuransi = $('#nama_asuransi').val();
	var tanggal       = $('#tanggal').val();
	var piutang       = $('#piutang').val();
	var tunai         = $('#tunai').val();
	var pasien_id     = $('#pasien_id').html()
	$.get(base + '/pasiens/getTransaksi/' + pasien_id,
		{
			nama_asuransi: nama_asuransi,
			tanggal:       tanggal,
			piutang:       piutang,
			tunai:         tunai
		},
		function (data, textStatus, jqXHR) {
			var temp = '';
			for (let i = 0, len = data.length; i < len; i++) {
				temp += '<tr>';
				temp += '<td><a href="' +base+ '/periksas/' + data[i].id+ '">' + data[i].tanggal + '</a></td>';
				temp += '<td>' + data[i].nama_asuransi + '</td>';
				temp += '<td class="uang">' + data[i].piutang + '</td>';
				temp += '<td class="uang">' + data[i].tunai + '</td>';
				temp += '<td class="uang">' + data[i].total + '</td>';
				temp += '<td class="uang">' + data[i].sudah_dibayar + '</td>';
				temp += '</tr>';
			}
			$('#container_transaksi').html(temp);
			$('.uang').each(function() {
				var money = $(this).html();
				money     = uang(money);
				console.log('uang');
				console.log(money);
				$(this).html(money);
			});
		}
	);
}
