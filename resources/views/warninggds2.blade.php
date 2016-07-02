@if(App\Classes\Yoga::cekGDSBulanIni($pasien_id)['bayar'])
    <div class="row">
        <div class="alert alert-danger">
            <strong>Pasien Harus Bayar Tunai Rp. 15.000,- karena cek GDS </strong>
            @if(App\Classes\Yoga::cekGDSBulanIni($pasien_id)['sudahGDS'])
                <div class="font-small"> pasien sudah pernah periksa Gula Darah bulan ini tanggal 
                    <span id="sudahGDS">{!! App\Classes\Yoga::updateDatePrep(App\Classes\Yoga::cekGDSBulanIni($pasien_id)['tanggal']) !!}</span>
                    , pemeriksaan Gula Darah saat ini harus bayar Rp. 15.000,- , plafon untuk BPJS hanya sebulan sekali
                </div>
            @else
                <div class="font-small"> gratis khusus hanya untuk pasien peserta BPJS > 50 tahun atau riwayat Diabetes Mellitus dan plafon hanya sebulan sekali
                </div>
            @endif
        </div>
    </div>
@endif