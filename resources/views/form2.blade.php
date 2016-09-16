<div class="alert alert-success">
    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            @if($antrianperiksa->asuransi_id == '32')
                <span  id="labelKecelakaanKerja" data-placement="top" title="Perhatian"  data-toggle="popover" title="Popover title" data-content="Jika Pasien Kecelakaan Kerja / Kecelakaan Lalulintas, Ganti Menjadi Kecelakaan Kerja"></span> Kecelakaan Kerja / Lalu Lintas :<br>
            @else
                <span  id="labelKecelakaanKerja" data-placement="top"  data-toggle="popover" title="Popover title" data-content="Jika Pasien Kecelakaan Kerja, Ganti Menjadi Kecelakaan Kerja"></span> Kecelakaan Kerja :<br>
            @endif
             {!! Form::select('kecelakaan_kerja', [
                null => '- pilih -',
                '1'  => 'Ya',
                '0'  => 'bukan '
             ], $antrianperiksa->kecelakaan_kerja, [
             'class' => 'form-control',
             'onchange' => 'kecelakaanKerjaChange(this);return false;',
             'id' => 'kecelakaanKerja'])!!}
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              Pembayaran : 
             <select name="asuransi_id" id="asuransi_id" class="form-control" onchange="asuransiIdChange(this);return false;">
                @if($antrianperiksa->asuransi_id == '0' && $antrianperiksa->pasien->asuransi_id != '0')
                    <option value="0" selected>Biaya Pribadi</option>
                    <option value="{!! $antrianperiksa->pasien->asuransi_id !!}">{!! $antrianperiksa->pasien->asuransi->nama !!}</option>
                @elseif($antrianperiksa->asuransi_id != '0')
                    <option value="0">Biaya Pribadi</option>
                    <option value="{!! $antrianperiksa->asuransi_id !!}" selected>{!! $antrianperiksa->asuransi->nama !!}</option>
                @else
                    <option value="0">Biaya Pribadi</option>
                @endif                 
             </select>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            Kehamilan : 
             {!! Form::select('hamil', [
                null => 'tidak tau',
                '1'  => 'hamil',
                '0'  => 'tidak hamil'
             ], $antrianperiksa->hamil, ['class' => 'form-control', 'id' => 'hamil'])!!}
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            Pemeriksa : 
            {!! Form::select('staf_id', $stafs, $antrianperiksa->staf_id, ['class' => 'form-control selectpick', 'id' => 'staf_id', 'data-live-search' => 'true'])!!}
        </div>
    </div>
</div>

@if($pakai_bayar_pribadi)
<div class="alert alert-danger">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            Bila Pasien datang karena kontrol akibat Kecelakaan Kerja / Kecelakaan Lalu Lintas, pelayanan tersebut tidak ditanggung oleh BPJS <br>
            Pilih Salah Satu Dibawah ini sebelum melanjutkan : <br>
            <strong>Apakah Pasien datang untuk kontrol karena Kecelakaan Lalu Lintas / Kecelakaan Kerja?</strong>
            <br><br>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button class="btn btn-success btn-block btn-lg" type="button" value="0" onclick="asuransiIdChange(this);return false;">Kecelakaan Kerja / Lalu Lintas</button>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <button class="btn btn-danger btn-block btn-lg" type="button" data-dismiss="alert" aria-label="Close">Bukan</button>            
        </div>
    </div>
</div>
@endif
@if($antrianperiksa->asuransi_id == 0 && !empty($antrianperiksa->keterangan))
    <div class="alert alert-danger">
        {{$antrianperiksa->keterangan}}
    </div>
@endif
<div class="panel panel-default">
    <div class="panel-body">
        <!-- Tab panes -->
        <div role="tabpanel">
        <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id='tab2panel'>
                <li role="presentation" class="active">
                    <a href="#status" aria-controls="status" role="tab" data-toggle="tab" id="tab-status">Status</a>
                </li>
                @if($antrianperiksa->poli == 'anc' || $antrianperiksa->poli == 'usg')
                    <li role="presentation">
                        <a href="#anc" aria-controls="anc" role="tab" data-toggle="tab" id="tab-anc">ANC</a>
                    </li>
                @endif
                @if($antrianperiksa->poli == 'usg')
                    <li role="presentation">
                        <a href="#usg" aria-controls="usg" role="tab" data-toggle="tab" id="tab-usg">USG</a>
                    </li> 
                @endif
                <li role="presentation">
                    <a href="#resep" aria-controls="resep" role="tab" data-toggle="tab" id="tab-resep">Resep</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="status">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col2">
                        <div class="panel panel-primary col2">
                            <div class="panel-heading">
                                <h3>Status Pasien</h3>
                            </div>
                            <div class="panel-body">
                                {!! Form::text('kali_obat', $antrianperiksa->asuransi->kali_obat, ['class' => 'hide', 'id' => 'kali_obat'])!!}
                                {!! Form::text('pasien_id', $antrianperiksa->pasien_id, ['class' => 'displayNone', 'id' => 'pasien_id']) !!}
                                {!! Form::text('jam', $antrianperiksa->jam, ['class' => 'displayNone']) !!}
                                {!! Form::text('_token', Session::token(), ['class' => 'displayNone', 'id'=>'token']) !!}
                                {!! Form::text('jam_periksa', date('H:i:s'), ['class' => 'displayNone']) !!}
                                {!! Form::text('tanggal', $antrianperiksa->tanggal, ['class' => 'displayNone']) !!}
                                {!! Form::text('poli', $antrianperiksa->poli, ['class' => 'displayNone']) !!}
                                {!! Form::text('adatindakan', $adatindakan, ['class' => 'hide', 'id' => 'adatindakan']) !!}
                                {!! Form::text('asisten_id', $antrianperiksa->asisten_id, ['class' => 'hide']) !!}
                                {!! Form::text('antrianperiksa_id', $antrianperiksa->id, ['class' => 'hide', 'id' => 'antrianperiksa_id']) !!}
                                {!! Form::text('periksa_awal', $antrianperiksa->periksa_awal, ['class' => 'hide']) !!}
                                {!! Form::text('antrian_id', $antrianperiksa->id, ['class' => 'displayNone']) !!}
                                {!! Form::text('keterangan_periksa', $antrianperiksa->keterangan, ['class' => 'displayNone']) !!}
                                {!! Form::text('dibantu', $antrianperiksa->staf->dibantu, ['class' => 'form-control hide', 'id' => 'dibantu'])!!}
                                {!! Form::text('antrian', $antrianperiksa->antrian, ['class' => 'displayNone']) !!}
                                <div class="row">
                                    {!! Form::text('berat_badan', $berat_badan, ['class' => 'form-control hide', 'id' => 'berat_badan'])!!}
                                    <div class="col-lg-12 col-md-12">
										<div class="form-group @if($errors->has('anamnesa'))has-error @endif">
										  {!! Form::label('anamnesa', 'Anamnesa', ['class' => 'control-label']) !!}
                                          {!! Form::textarea('anamnesa', null, ['class' => 'form-control textareacustom', 'id' => 'anamnesa'])!!}
										  @if($errors->has('anamnesa'))<code>{{ $errors->first('anamnesa') }}</code>@endif
										</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
										<div class="form-group @if($errors->has('pemeriksaan_fisik'))has-error @endif">
										  {!! Form::label('pemeriksaan_fisik', 'Pemeriksaan Fisik', ['class' => 'control-label']) !!}
                                          {!! Form::textarea('pemeriksaan_fisik', $pemeriksaan_awal, ['class' => 'form-control textareacustom', 'id' => 'pemeriksaan_fisik'])!!}
										  @if($errors->has('pemeriksaan_fisik'))<code>{{ $errors->first('pemeriksaan_fisik') }}</code>@endif
										</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
										<div class="form-group @if($errors->has('pemeriksaan_penunjang'))has-error @endif">
										  {!! Form::label('pemeriksaan_penunjang', 'Pemeriksaan Penunjang, Injeksi dan Tindakan', ['class' => 'control-label']) !!}
                                            {!! Form::textarea('pemeriksaan_penunjang', $penunjang, ['class' => 'form-control textareacustom', 'id' => 'pemeriksaan_penunjang'])!!}
										  @if($errors->has('pemeriksaan_penunjang'))<code>{{ $errors->first('pemeriksaan_penunjang') }}</code>@endif
										</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="diagnosa_id" id="lblDiagnosa" data-placement="left"  data-toggle="popover" title="Popover title" data-content="Jika ASMA BERAT, berikan bersama dexa inj IV 2 ampul, dan prednison dosis tinggi, Decafil 20 tablet, termasuk untuk pasien BPJS">Diagnosa</label><br />
                                            <div class="form-group">
                                                <div class="input-group">
                                                    {!! Form::select('diagnosa_id', $diagnosa, null, [
                                                        'class'             => 'selectpick form-control',
                                                        'data-live-search'  => 'true',
                                                        'aria-describedby'  => 'showModal1',
                                                        'title'             => 'Perhatikan ICD 10',
                                                        'onchange'          => 'diagnosaChange();return false;',
                                                        'id'                => 'ddlDiagnosa'
                                                    ]) !!}
                                                    <span class="input-group-addon anchor" id="showModal1" data-toggle="modal" data-target="#exampleModal"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>
                                                </div>
                                                     @if ($errors->first('diagnosa_id'))
                                                       <div><code>{!! $errors->first('diagnosa_id') !!} </code></div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="keterangan_boleh_dirujuk">
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
										<div class="form-group @if($errors->has('keterangan_diagnosa'))has-error @endif">
										  {!! Form::label('keterangan_diagnosa', 'Keterangan Diagnosa', ['class' => 'control-label']) !!}
                                          {!! Form::text('keterangan_diagnosa', null, ['class' => 'form-control', 'id' => 'keterangan_diagnosa'])!!}
										  @if($errors->has('keterangan_diagnosa'))<code>{{ $errors->first('keterangan_diagnosa') }}</code>@endif
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col2">
                        <div class="panel panel-info col2">
                            <div class="panel-heading">
                                <h3>Pembayaran : {!! $antrianperiksa->asuransi->nama !!}</h3>
                            </div>
                            <div class="panel-body">
                                @if($antrianperiksa->asuransi->umum != ''  && $antrianperiksa->asuransi->umum != '[]' && $antrianperiksa->asuransi->umum != null)
                                   @foreach(json_decode($antrianperiksa->asuransi->umum, true) as $ket)
                                        <p>
                                            {!! $ket !!}
                                        </p>
                                   @endforeach
                                @else
                                <h2 class="text-center">Tidak ada catatan penting</h2>
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="usg">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3>Formulir USG</h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <table class="table table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td>Presentasi</td>
                                                    <td colspan="2">{!! Form::text('presentasi', $presentasi, ['class' => 'form-control hasil', 'id' =>'usg_presentasi'])!!}</td>
                                                </tr>
                                                <tr>
                                                    <td>Biparietal Diameter</td>
                                                    <td>
                                                        <div class="input-group">
                                                            {!! Form::text('BPD_w', $BPD_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'BPD_w'])!!}
                                                            <span class="input-group-addon" id="addonBPDw">W</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            {!! Form::text('BPD_d', $BPD_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'BPD_d' ])!!}
                                                            <span class="input-group-addon" id="addonBPDd">D</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Lilitan Tali Pusat</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            {!! Form::text('LTP', $LTP, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'usg_ltp'])!!}
                                                            <span class="input-group-addon" id="addonLTP">lilitan</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fetal Heart Rate</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            {!! Form::text('FHR', $FHR, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'usg_djj'])!!}
                                                            <span class="input-group-addon" id="addonFHR">bpm</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Abdominal Circumference</td>
                                                    <td>
                                                        <div class="input-group">
                                                            {!! Form::text('AC_w', $AC_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'AC_w'])!!}
                                                            <span class="input-group-addon" id="addonACw">W</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            {!! Form::text('AC_d', $AC_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'AC_d'])!!}
                                                            <span class="input-group-addon" id="addonACd">D</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <table class="table table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td>Estimated Fetal Weight</td>
                                                    <td colspan="2">
                                                        <div class="input-group">
                                                            {!! Form::text('EFW', $EFW, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'usg_efw'])!!}
                                                            <span class="input-group-addon" id="addonEFW">gram</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Femur Length</td>
                                                    <td>
                                                        <div class="input-group">
                                                            {!! Form::text('FL_w', $FL_w, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'FL_w'])!!}
                                                            <span class="input-group-addon" id="addonFLw">W</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            {!! Form::text('FL_d', $FL_d, ['class' => 'form-control hasil', 'dir' => 'rtl', 'id' => 'FL_d'])!!}
                                                            <span class="input-group-addon" id="addonFLd">D</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Sex</td>
                                                    <td colspan="2">
                                                        {!! Form::select('Sex',
                                                        [
                                                            'tak dpt dinilai' => 'tak dpt dinilai',
                                                            'kemungkinan laki-laki' => 'Laki-Laki',
                                                            'kemungkinan perempuan' => 'Perempuan'
                                                        ]
                                                        , $Sex, ['class' => 'form-control hasil', 'id' => 'usg_sex'])!!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Plasenta</td>
                                                    <td colspan="2">
                                                        {!! Form::text('Plasenta', $Plasenta, ['class' => 'form-control hasil', 'id' => 'usg_plasenta'])!!}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Total</td>
                                                    <th>
                                                        {!! Form::text('total_afi', $total_afi, ['class' => 'form-control hasil', 'id' => 'total_afi'])!!}
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group @if($errors->has('kesimpulan'))has-error @endif">
										  {!! Form::label('kesimpulan', 'Kesimpulan', ['class' => 'control-label']) !!}
                                            {!! Form::textarea('kesimpulan', $kesimpulan, ['class' => 'form-control textareacustom'])!!}
										  @if($errors->has('kesimpulan'))<code>{{ $errors->first('kesimpulan') }}</code>@endif
										</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group @if($errors->has('saran'))has-error @endif">
										  {!! Form::label('saran', 'Saran', ['class' => 'control-label']) !!}
                                            {!! Form::text('saran', $saran, ['class' => 'form-control'])!!}
										  @if($errors->has('saran'))<code>{{ $errors->first('saran') }}</code>@endif
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="resep">
                <div class="row">
                    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 col3">
                        <div id="resume"></div>
                        @include('perscribe2', ['showSubmit' => false, 'berat_badan_input' => $antrianperiksa->berat_badan, 'transaksi' => $transaksi])
                    </div><!-- .col 7 -->
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 col3">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id='peringatan'>
                                
                            </div>
                        </div>
                        @if($antrianperiksa->asuransi->tipe_asuransi == '4')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  id='bilaTipeFlat'>
                                    <div class="alert alert-success">
                                        <ul>
                                            <li>
                                                Plafon obat yang bisa digunakan sekarang : <span class="strong" id="plafon"> {!! $plafon['plafon'] !!}</span>
                                            </li>
                                            <li>
                                                Jumlah Pasien {{ $antrianperiksa->asuransi->nama }} saat ini : <strong class="uang">{{ $plafon['kunjungan'] }}</strong>
                                            </li>
                                            <li>
                                                Jumlah Dibayar Tunai {{ $antrianperiksa->asuransi->nama }} saat ini : <strong class="uang">{{ $plafon['tunai'] }}</strong>
                                            </li>
                                            <li>
                                                Jumlah Utilisasi Obat {{ $antrianperiksa->asuransi->nama }} saat ini : <strong class="uang">{{ $plafon['utilisasi'] }}</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <input type="text" id="plafon_total" value="{!!$plafon['plafon']!!}" class="hide">
                                </div>
                            </div>
                        @endif
                        @if($antrianperiksa->asuransi_id == '32')
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
                                    <div class="panel panel-info">
                                        <div class="panel-heading">Obat yang tidak ditanggung BPJS</div>
                                        <div class="panel-body">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Obat</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='bilaTipeBPJS'>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>Total </td>
                                                        <td id="totalBilaTipeBPJS" class="uang"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">Tindakan yang tidak ditanggung BPJS</div>
                                        <div class="panel-body">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Tindakan</th>
                                                        <th>Biaya</th>
                                                    </tr>
                                                </thead>
                                                <tbody id='dibayarTIndakanBpjs'>

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td>Total </td>
                                                        <td id="TotalDibayarTindakanBPJS" class="uang"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="alert alert-danger" id="adaYangDibayar" style="display:none;">
                                <h2>Total Yand Dibayar</h2>
                                <strong><h1 class="uang" id="jumlahDibayarBpjs"></h1></strong>
                            </div>
                            <div class="row hide" id="kekuranganFlat">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Panel title</h3>
                                        </div>
                                        <div class="panel-body">
                                            <h3>
                                                Ada Biaya Tambahan Senilai 
                                            </h3>
                                            <h2 class="uang" id="uangKekuranganFlat">
                                                
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        {!! Form::submit('Submitsss', [
                        'class' => 'displayNone',
                        'id' => 'submitFormPeriksa'])!!}
                        <button type="button" class="btn btn-success btn-lg btn-block" id="LinkButton2" >Submit</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli )!!}" class="btn btn-danger btn-lg btn-block">Cancel</a>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="anc">
                @include('anc')
            </div>
        </div>
    </div>
</div>
@if($antrianperiksa->asuransi_id == '32')
    <div class="modal" id="cekFoto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="text-center">{!! $antrianperiksa->pasien->nama!!}, {!! App\Classes\Yoga::datediff($antrianperiksa->pasien->tanggal_lahir, date('Y-m-d'))!!}</h4>
                </div>
                <div class="modal-body text-center">
                    <img src="{!! url($antrianperiksa->pasien->image) !!}? {{ time() }}" alt="" width="500px" height="375px">
                    <h4 class="text-center">Jika foto pasien tidak cocok, minta pasien untuk mendaftar lagi sebagai pasien umum</h4>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-lg btn-success btn-block" onclick="fokusKeAnemnesa(); return false;">Benar</button>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <a href="{!! url('ruangperiksa/' . $antrianperiksa->poli) !!}" class="btn btn-lg btn-danger btn-block">Tidak Benar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@include('tunggu');

