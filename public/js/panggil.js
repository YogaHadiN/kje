function panggil(antrian_id, ruangan, panggil_pasien){
	panggil_pasien = panggil_pasien || true;
	ruangan = 'ruangperiksasatu';
	$.get(base + '/poli/ajax/panggil_pasien',
		{
			antrian_id: antrian_id,
			panggil_pasien: panggil_pasien,
			ruangan: ruangan
		},
		function (data, textStatus, jqXHR) {
			// pglPasien(data);
		}
	);
}
