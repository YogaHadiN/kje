@if($cekGdsBulanIni['bayar'])
    <div class="row">
        <div class="alert alert-danger">
            <strong>Pemeriksaan Gula Darah Tidak ditanggung untuk pasien ini-</strong>
            @if($cekGdsBulanIni['sudahGDS'])
                <div class="font-small"> pasien sudah pernah periksa Gula Darah bulan ini tanggal 
                    <span id="sudahGDS">{!! App\Classes\Yoga::updateDatePrep($cekGdsBulanIni['tanggal']) !!}</span>
                    , pemeriksaan Gula Darah saat ini harus bayar Rp. 15.000,- 
                </div>
            @else
                <div class="font-small"> gratis khusus hanya untuk pasien peserta BPJS > 50 tahun atau riwayat Diabetes Mellitus dan plafon hanya sebulan sekali, pasien sudah periksa sebelumnya pada tanggal {{ App\Classes\Yoga::updateDatePrep( $cekGdsBulanIni['tanggal'] ) }}
                </div>
            @endif
        </div>
    </div>
@else
    <div class="row">
        <div class="alert alert-success">
            <strong>Pemeriksaan Gula Darah Ditanggung untuk pasien ini-</strong>
            <div class="font-small"> 
				@if( App\Classes\Yoga::umur($antrianperiksa->pasien->tanggal_lahir) > 50)
                    Karena Usia Pasien diatas 50 Tahun
                @else 
                    Pasien pernah menderita Kencing Manis
                @endif
            </div>
        </div>
    </div>
@endif
