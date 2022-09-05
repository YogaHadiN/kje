@extends('layout.master')

@section('title') 
Klinik Jati Elok | Ruang Pemeriksaan Fisik

@stop
@section('page-title') 
<h2>Buat A</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li>
                <a href="{{ url('antrianpolis')}}">Antrian Poli</a>
            </li>
            <li class="active">
                <strong>Ruang Pemeriksaan Fisik</strong>
            </li>
</ol>
@stop
@section('content') 
    {!! Form::open(['url' => 'antrianperiksas/' . $antrian_poli->id, 'method' => 'post']) !!}
<div class="row">
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        @if( $antrian_poli->antrian )
            <button class="btn btn-success" type="button" onclick="panggil('{{ $antrian_poli->antrian->id }}', 'ruangpf');return false;">
                <i class="fas fa-volume-up fa-3x"></i>
            </button>
        @endif
        @include('fotoPasien', ['pasien' => $antrian_poli->pasien])
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <tbody>
                    <tr>
                        <td>Nama Dokter</td>
                        <td>{{ $antrian_poli->staf->nama }}</td>
                    </tr>
                    <tr>
                        <td>Pembayaran</td>
                        <td>{{ $antrian_poli->asuransi->nama }}</td>
                    </tr>
                    <tr>
                        <td>Nama Poli</td>
                        <td>{{ $antrian_poli->poli->poli }}</td>
                    </tr>
                    @if( $antrian_poli->asuransi->tipe_asuransi_id == 5 )
                    <tr>
                        <td>Prolanis HT</td>
                        <td>{{ $antrian_poli->pasien->prolanis_ht ? "Ya" : "Tidak" }}</td>
                    </tr>
                    <tr>
                        <td>Prolanis DM</td>
                        <td>{{ $antrian_poli->pasien->prolanis_dm ? "Ya" : "Tidak" }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>
                            <div class="form-group @if($errors->has('sex')) has-error @endif">
                              {!! Form::select('sex',[
                                  0 => 'Perempuan',
                                  1 => 'Laki-Laki',
                              ] , $antrian_poli->pasien->sex, [
                                'class' => 'form-control',
                                'placeholder' => '- Pilih -',
                              ]) !!}
                              @if($errors->has('sex'))<code>{{ $errors->first('sex') }}</code>@endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Bukan Peserta KJE
                        </td>
                        <td>
                            <div class="form-group @if($errors->has('peserta_klinik')) has-error @endif">
                                {!! Form::select('peserta_klinik', [
                                    0 => 'Tidak',
                                    1 => 'Ya',
                                ] , $antrian_poli->bukan_peserta, [
                                    'class' => 'form-control',
                                    'placeholder' => '- Pilih -'
                                  ]) !!}
                              @if($errors->has('peserta_klinik'))<code>{{ $errors->first('peserta_klinik') }}</code>@endif
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-bordered">
                <tbody>
                    <tr>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="verifikasi_wajah">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            Verifikasi Wajah Pasien (Minta pasien membuka masker sebentar)
                            <ul>
                                <li>
                                    Jika foto pasien tidak jelas ubah foto pasien <a href="{{ url('pasiens/' . $antrian_poli->pasien->id . '/edit') }}" target="_blank">disini</a>
                                </li>
                                @if( $antrian_poli->asuransi->tipe_asuransi_id == 5 )
                                    <li>Jika wajah pasien tidak sama, daftarkan ulang pasien sebagai Pasien Pribadi, Karena terdapat dugaan Fraud dari pihak pasien</li>
                                @else
                                    <li>Jika wajah pasien tidak sama, daftarkan ulang pasien, karena salah identifikasi</li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                    @if( !is_null( $antrian_poli->pasien->periksa_terakhir ) )
                        <tr>
                            <td colspan="2">
                                <strong>Keluhan sebelumnya :</strong> <br>
                                (Tanggal : {{ $antrian_poli->pasien->periksa_terakhir->tanggal }}) {{ $antrian_poli->pasien->periksa_terakhir->anamnesa }}
                                <br>
                                {!! Form::select('previous_complaint_resolved', [
                                    0 => 'Tidak Membaik',
                                    1 => 'Membaik',
                                ] ,null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Apakah Keluhan Sebelumnya membaik?'
                                ]) !!}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="verifikasi_alergi_obat">
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            Tanyakan riwayat alergi obat pasien <br>
                            @include('alergi', ['pasien' => $antrian_poli->pasien])
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('sistolik')) has-error @endif">
                                    {!! Form::label('sistolik', 'Sistolik', ['class' => 'control-label']) !!}
                                    {!! Form::text('sistolik' , null, ['class' => 'form-control']) !!}
                                    @if($errors->has('sistolik'))<code>{{ $errors->first('sistolik') }}</code>@endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('diastolik')) has-error @endif">
                                    {!! Form::label('diastolik', 'Diastolik', ['class' => 'control-label']) !!}
                                    {!! Form::text('diastolik' , null, ['class' => 'form-control']) !!}
                                    @if($errors->has('diastolik'))<code>{{ $errors->first('diastolik') }}</code>@endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('berat_badan')) has-error @endif">
                                      {!! Form::label('berat_badan', 'Berat Badan', ['class' => 'control-label']) !!}
                                         <div class="input-group">
                                             {!! Form::text('berat_badan' , null, [
                                                'id'               => 'berat_badan',
                                                'class'            => 'form-control',
                                                'dit'              => 'rtl',
                                                'aria-describedby' => 'addonBeratBadan'
                                             ]) !!}
                                            <span class="input-group-addon" id="addonBeratBadan">kg</span>
                                        </div>
                                      @if($errors->has('berat_badan'))<code>{{ $errors->first('berat_badan') }}</code>@endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('suhu')) has-error @endif">
                                      {!! Form::label('suhu', 'Suhu', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                              {!! Form::text('suhu' , null, [
                                                'id'               => 'suhu',
                                                'class'            => 'form-control',
                                                'dit'              => 'rtl',
                                                'aria-describedby' => 'addonSuhu'
                                             ]) !!}
                                            <span class="input-group-addon" id="addonSuhu"><sup>o</sup>C</span>
                                        </div>
                                      @if($errors->has('suhu'))<code>{{ $errors->first('suhu') }}</code>@endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('tinggi_badan')) has-error @endif">
                                      {!! Form::label('tinggi_badan', 'Tinggi Badan', ['class' => 'control-label']) !!}
                                        <div class="input-group">
                                          {!! Form::text('tinggi_badan' , null, [
                                                'id'               => 'tinggi_badan',
                                                'class'            => 'form-control',
                                                'dit'              => 'rtl',
                                                'aria-describedby' => 'addonTinggiBadan'
                                             ]) !!}
                                            <span class="input-group-addon" id="addonTinggiBadan">cm</span>
                                        </div>
                                      @if($errors->has('tinggi_badan'))<code>{{ $errors->first('tinggi_badan') }}</code>@endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('kecelakaan_kerja')) has-error @endif">
                                      {!! Form::label('kecelakaan_kerja', 'Kecelakaan Kerja', ['class' => 'control-label']) !!}
                                      {!! Form::select('kecelakaan_kerja', $kecelakaan_kerja_list , null, [
                                        'class' => 'form-control',
                                        'placeholder' => '- Pilih -'
                                      ]) !!}
                                      @if($errors->has('kecelakaan_kerja'))<code>{{ $errors->first('kecelakaan_kerja') }}</code>@endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('hamil')) has-error @endif">
                                        {!! Form::label('hamil', 'Hamil', ['class' => 'control-label']) !!}
                                        {!! Form::select('hamil',[
                                            0 => 'Tidak Hamil',
                                            1 => 'Hamil',
                                        ] , $antrian_poli->pasien->sex == 1? 0 : null, [
                                            'class' => 'form-control',
                                            'placeholder' => '- Pilih -'
                                        ]) !!}
                                        @if($errors->has('hamil'))<code>{{ $errors->first('hamil') }}</code>@endif
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group @if($errors->has('menyusui')) has-error @endif">
                                        {!! Form::label('menyusui', 'Menyusui', ['class' => 'control-label']) !!}
                                        {!! Form::select('menyusui',[
                                            0 => 'Tidak Menyusui',
                                            1 => 'Menyusui',
                                        ] , $antrian_poli->pasien->sex == 1? 0 : null, [
                                            'class' => 'form-control',
                                            'placeholder' => '- Pilih -'
                                        ]) !!}
                                        @if($errors->has('menyusui'))<code>{{ $errors->first('menyusui') }}</code>@endif
                                    </div>
                                </div>
                            </div>


                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="row">
                                @if( $cekGDSDiNurseStation )
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group @if($errors->has('gds')) has-error @endif">
                                          {!! Form::label('gds', 'Gula Darah', ['class' => 'control-label']) !!}
                                          {!! Form::text('gds' , null, ['class' => 'form-control']) !!}
                                          @if($errors->has('gds'))<code>{{ $errors->first('gds') }}</code>@endif
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group @if($errors->has('asisten_id')) has-error @endif">
                                      {!! Form::label('asisten_id', 'Nama Asisten', ['class' => 'control-label']) !!}
                                      {!! Form::select('asisten_id', $staf_list , null, [
                                        'class'            => 'form-control selectpick',
                                        'data-live-search' => 'true',
                                        'placeholder'      => '- Pilih Asisten -'
                                      ]) !!}
                                      @if($errors->has('asisten_id'))<code>{{ $errors->first('asisten_id') }}</code>@endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
        {!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <a class="btn btn-danger btn-block" href="{{ url('antrianpolis') }}">Cancel</a>
    </div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
    <script type="text/javascript" charset="utf-8">
        function dummySubmit(control){
            if(validatePass2(control)){
                $('#submit').click();
            }
        }
    </script>
    {!! HTML::script('js/alergi.js')!!} 
    <script>
    var base  = '{!! url('/') !!}';
    </script>
     <script src="{!! asset('js/panggil.js') !!}"></script>
@stop
