	                <div class="alert">
	                  Surat keterangan sakit selama {!! $periksa->suratSakit->hari !!} hari mulai tanggal {!! App\Classes\Yoga::updateDatePrep($periksa->suratSakit->tanggal_mulai) !!} s/d {!! $periksa->suratSakit->akhir !!}
	                  <hr>
	                  <div class="font-small">
	                  		Saya yang bertanda tangan di bawah ini menyatakan bersedia agar Diagnosa yang tertulis di lembar ini dituliskan di surat keterangan sakit. Segala kejadian yang terjadi karena penulisan tersebut menjadi tanggung jawab saya sepenuhnya
	                  		<br><br><br><br>
							<div class="text-right">
	                  		{!! $periksa->pasien->nama !!}
							</div>
	                  </div>
	                </div>
