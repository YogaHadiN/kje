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
    {!! Form::text('pasien_id', $antrian_poli->pasien_id, ['class' => 'form-control hide', 'id' =>'pasien_id']) !!}
    {!! Form::text('antrian_poli_id', $antrian_poli->id, ['class' => 'form-control hide', 'id' =>'antrian_poli_id']) !!}
    {!! Form::text('antrian_id', $antrian_poli->antrian->id, ['class' => 'form-control hide', 'id' =>'antrian_id']) !!}
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
                                'class' => 'form-control rq',
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
        <div class="form-group @if($errors->has('verifikasi_wajah')) has-error @endif">
          {!! Form::label('verifikasi_wajah', 'Verifikasi Wajah Pasien', ['class' => 'control-label']) !!}
          {!! Form::select('verifikasi_wajah', $verifikasi_wajah_list , null, [
                'class'       => 'form-control rq',
                'placeholder' => 'Apakah wajah pasien sama dengan foto di aplikasi? (Minta pasien membuka masker sebentar)',
                'onchange'    => 'verifikasiWajahChange(this); return false;',
          ]) !!}
          @if($errors->has('verifikasi_wajah'))<code>{{ $errors->first('verifikasi_wajah') }}</code>@endif
        </div>
        @if( !is_null( $antrian_poli->pasien->periksa_terakhir ) )
            <strong>Keluhan sebelumnya :</strong> <br>
            (Tanggal : {{ $antrian_poli->pasien->periksa_terakhir->tanggal }}) {{ $antrian_poli->pasien->periksa_terakhir->anamnesa }}
            <div class="form-group @if($errors->has('previous_complaint_resolved')) has-error @endif">
              {!! Form::label('previous_complaint_resolved', 'Keluhan Sebelumnya', ['class' => 'control-label']) !!}
                {!! Form::select('previous_complaint_resolved', [
                    0 => 'Tidak Membaik',
                    1 => 'Membaik',
                ] ,null, [
                    'class' => 'form-control rq',
                    'placeholder' => 'Apakah Keluhan Sebelumnya membaik?'
                ]) !!}
              @if($errors->has('previous_complaint_resolved'))<code>{{ $errors->first('previous_complaint_resolved') }}</code>@endif
            </div>
        @endif
        @if ( $antrian_poli->pasien->alergies->count() )
            <div class="alert alert-danger">
                <h2>Daftar Alergi Obat Pasien</h2>
                <ul>
                    @foreach($antrian_poli->pasien->alergies as $alergi)	
                        <li>{{ $alergi->generik->generik }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group @if($errors->has('verifikasi_alergi_obat')) has-error @endif">
          {!! Form::label('verifikasi_alergi_obat', 'Verifikasi Alergi Obat', ['class' => 'control-label']) !!}
          {!! Form::select('verifikasi_alergi_obat', [
              '0' => $antrian_poli->pasien->alergies->count() > 0 ? 'Tidak ada alergi obat lainnya' :'Tidak ada alergi obat' ,
              '1' => $antrian_poli->pasien->alergies->count() > 0 ? 'Ada alergi obat lainnya' :'Ada alergi obat' ,
          ] , null, [
            'class' => 'form-control rq',
            'placeholder' => $antrian_poli->pasien->alergies->count() < 1 ?'Apakah pasien memiliki alergi obat?' : 'Tanyakan apakah ada alergi obat selain yang disebutkan sebelumnya?',
      ]) !!}
          @if($errors->has('verifikasi_alergi_obat'))<code>{{ $errors->first('verifikasi_alergi_obat') }}</code>@endif
        </div>
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
        <div class="row">
            @if( $cekGDSDiNurseStation )
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group @if($errors->has('gds')) has-error @endif">
                      {!! Form::label('gds', 'Gula Darah', ['class' => 'control-label']) !!}
                      {!! Form::text('gds' , null, ['class' => 'form-control rq']) !!}
                      @if($errors->has('gds'))<code>{{ $errors->first('gds') }}</code>@endif
                    </div>
                </div>
            @endif
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="form-group @if($errors->has('asisten_id')) has-error @endif">
                  {!! Form::label('asisten_id', 'Nama Asisten', ['class' => 'control-label']) !!}
                  {!! Form::select('asisten_id', $staf_list , null, [
                    'class'            => 'form-control rq selectpick',
                    'data-live-search' => 'true',
                    'placeholder'      => '- Pilih Asisten -'
                  ]) !!}
                  @if($errors->has('asisten_id'))<code>{{ $errors->first('asisten_id') }}</code>@endif
                </div>
            </div>
        </div>
        @if ($antrian_poli->asuransi->tipe_asuransi_id == 5)
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>Daftar Pengantar Pasien
                    <button class="btn btn-xs btn-success" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </h2>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Hubungan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="pengantar_container">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
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
@include('ruangperiksas.cekfoto', ['antrianperiksa' => $antrian_poli])
{!! Form::text('pengantars', '[]', ['class' => 'form-control hide', 'id' => 'pengantars']) !!}
{!! Form::text('hubungan_keluargas', json_encode($hubungan_keluarga_list), ['class' => 'form-control hide', 'id' => 'hubungan_keluargas']) !!}
{!! Form::close() !!}
<!-- Large modal -->
<div class="modal fade bs-example-modal-lg" id="modalCariPengantar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:1250px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Cari Pengantar Pasien</h4>
        </div>
        <div class="modal-body">
            @include('pasiens.form', ['createLink' => false])
        </div>
    </div>
  </div>
</div>
@stop
@section('footer') 
     <script src="{!! asset('js/panggil.js') !!}"></script>
    {!! HTML::script('js/alergi.js')!!} 
    {!! HTML::script('js/antrian_periksa_create.js')!!} 
	{!! HTML::script('js/pasiens.js')!!}
	{{-- {!! HTML::script('js/rowEntryPengantar.js')!!} --}}
	{{-- {!! HTML::script('js/select2/dist/js/select2.min.js')!!} --}}
	{{-- {!! HTML::script('js/pengantar.js')!!} --}}
@stop
