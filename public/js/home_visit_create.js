function rowEntry(control) {
	var hasClassInfo = $(control).closest('tr').hasClass('info');
	if (hasClassInfo) {
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Pasien yang sudah kontak bulan ini tidak dapat dimasukkan sebagai Kunjungan Sehat. Silahkan pilih pasien yang bukan latar belakang biru muda'
		})
	} else {
		var id = $(control).closest('tr').find('td:first div').html();
		var url = base + '/home_visit/create/pasien/' + id;
		window.location = url;
	}
}
