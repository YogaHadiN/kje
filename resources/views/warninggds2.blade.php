@if(App\Models\Classes\Yoga::cekGDSBulanIni($periksa->pasien, $periksa)['bayar'])
    <div class="row">
        <div class="alert alert-danger">
            <strong>Pasien Harus Bayar Tunai Rp. 15.000,- karena cek GDS </strong>
            @if(App\Models\Classes\Yoga::cekGDSBulanIni($periksa->pasien, $periksa)['sudahGDS'])
                <div class="font-small"> pasien sudah pernah periksa Gula Darah bulan ini tanggal 
                    <span id="sudahGDS">{!! App\Models\Classes\Yoga::updateDatePrep(App\Models\Classes\Yoga::cekGDSBulanIni($periksa->pasien, $periksa)['tanggal']) !!}</span>
                    , pemeriksaan Gula Darah saat ini harus bayar Rp. 15.000,- , plafon untuk BPJS hanya sebulan sekali
                </div>
            @else
                <div class="font-small"> gratis khusus hanya untuk pasien peserta BPJS > 50 tahun dan atau riwayat Diabetes Mellitus dan plafon hanya sebulan sekali
                    usia pasien saat ini {{ App\Models\Classes\Yoga::datediff( $periksa->pasien->tanggal_lahir->format('Y-m-d'), $periksa->tanggal ) }}
                </div>
            @endif
        </div>
    </div>
@endif
