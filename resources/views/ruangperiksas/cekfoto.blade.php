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
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <button type="button" class="btn btn-lg btn-success btn-block" onclick="fokusKeAnemnesa(); return false;">Benar</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli_id) !!}" class="btn btn-lg btn-danger btn-block">Tidak Benar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
