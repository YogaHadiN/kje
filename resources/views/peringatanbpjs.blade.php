 <div class="alert alert-warning" id="cekBPJSkontrol">
 	@if($ns)
		Jika Pasien termasuk dalam Kecelakaan Kerja / Kecelakaan Lalu Lintas, harap Ubah keterangan Kecelakaan Kerja / Lalu Lintas manjadi benar, atau klik <a href="#" onclick="ubahKKKLL();return false;">disini</a>
 	@else
	  Pastikan Pasien Bukan Kontrol Karena Kecelakaan Kerja <br>
	  Atau Kecelakaan Lalu Lintas, Jika Ya, Sampaikan ke Pasien Bahwa <br>
	  Tidak bisa dilayani dengan BPJS karena KLL dan Kecelakaan Kerja tidak ditanggung BPJS <br>
	  (Walaupun Hanya Untuk Kontrol setelah tindakan).
 	@endif
</div>
<div class="alert alert-danger" id="cekGDSBPJS">
  Pasien tidak bisa periksa GDS pakai BPJS karena <span id="karena"></span>
</div>
