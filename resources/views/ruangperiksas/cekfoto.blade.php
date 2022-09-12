<div class="modal" id="cekFoto">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-center">{!! $antrianperiksa->pasien->nama!!}, {!! App\Models\Classes\Yoga::datediff($antrianperiksa->pasien->tanggal_lahir->format('Y-m-d'), date('Y-m-d'))!!}</h4>
            </div>
            <div class="modal-body text-center">
                <img src="{{ \Storage::disk('s3')->url($antrianperiksa->pasien->image) }}" alt="" width="500px" height="375px">
                <h4 class="text-center">Jika foto pasien tidak cocok, minta pasien untuk mendaftar lagi sebagai pasien umum</h4>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                        <button type="button" class="btn btn-lg btn-danger btn-block" onclick="fokusKeAnemnesa(); return false;">Tutup</button>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                        @if( $antrianperiksa->antrian )
                            <button class="btn btn-success btn-sm btn-block" type="button" onclick="panggil('{{ $antrianperiksa->antrian->id }}', 'ruangpf');return false;">
                                <i class="fas fa-volume-up fa-3x"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
