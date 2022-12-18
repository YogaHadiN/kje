@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Antrian

@stop
@section('page-title') 
<h2>Edit Antrian</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Edit Antrian</strong>
            </li>
</ol>

@stop
@section('content') 
    {!! Form::open(['url' => 'antrians/' . $antrian->id, 'method' => 'put']) !!}
    <div class="form-group @if($errors->has('antrian_id')) has-error @endif">
      {!! Form::label('antrian_id', 'antrian_id', ['class' => 'control-label']) !!}
      {!! Form::text('antrian_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('antrian_id'))<code>{!! $errors->first('antrian_id') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('jenis_antrian_id')) has-error @endif">
      {!! Form::label('jenis_antrian_id', 'jenis_antrian_id', ['class' => 'control-label']) !!}
      {!! Form::text('jenis_antrian_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('jenis_antrian_id'))<code>{!! $errors->first('jenis_antrian_id') !!}</code>@endif
    </div>

    <div class="form-group @if($errors->has('url')) has-error @endif">
      {!! Form::label('url', 'url', ['class' => 'control-label']) !!}
      {!! Form::text('url' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('url'))<code>{!! $errors->first('url') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('nomor')) has-error @endif">
      {!! Form::label('nomor', 'nomor', ['class' => 'control-label']) !!}
      {!! Form::text('nomor' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('nomor'))<code>{!! $errors->first('nomor') !!}</code>@endif
    </div>

    <div class="form-group @if($errors->has('antriable_id')) has-error @endif">
      {!! Form::label('antriable_id', 'antriable_id', ['class' => 'control-label']) !!}
      {!! Form::text('antriable_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('antriable_id'))<code>{!! $errors->first('antriable_id') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('antriable_type')) has-error @endif">
      {!! Form::label('antriable_type', 'antriable_type', ['class' => 'control-label']) !!}
      {!! Form::text('antriable_type' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('antriable_type'))<code>{!! $errors->first('antriable_type') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('dipanggil')) has-error @endif">
      {!! Form::label('dipanggil', 'dipanggil', ['class' => 'control-label']) !!}
      {!! Form::text('dipanggil' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('dipanggil'))<code>{!! $errors->first('dipanggil') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('no_telp')) has-error @endif">
      {!! Form::label('no_telp', 'no_telp', ['class' => 'control-label']) !!}
      {!! Form::text('no_telp' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('no_telp'))<code>{!! $errors->first('no_telp') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('nama')) has-error @endif">
      {!! Form::label('nama', 'nama', ['class' => 'control-label']) !!}
      {!! Form::text('nama' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('nama'))<code>{!! $errors->first('nama') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('tanggal_lahir')) has-error @endif">
      {!! Form::label('tanggal_lahir', 'tanggal_lahir', ['class' => 'control-label']) !!}
      {!! Form::text('tanggal_lahir' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('tanggal_lahir'))<code>{!! $errors->first('tanggal_lahir') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('tenant_id')) has-error @endif">
      {!! Form::label('tenant_id', 'tenant_id', ['class' => 'control-label']) !!}
      {!! Form::text('tenant_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('tenant_id'))<code>{!! $errors->first('tenant_id') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('kode_unik')) has-error @endif">
      {!! Form::label('kode_unik', 'kode_unik', ['class' => 'control-label']) !!}
      {!! Form::text('kode_unik' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('kode_unik'))<code>{!! $errors->first('kode_unik') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('registrasi_pembayaran_id')) has-error @endif">
      {!! Form::label('registrasi_pembayaran_id', 'registrasi_pembayaran_id', ['class' => 'control-label']) !!}
      {!! Form::text('registrasi_pembayaran_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('registrasi_pembayaran_id'))<code>{!! $errors->first('registrasi_pembayaran_id') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('nomor_bpjs')) has-error @endif">
      {!! Form::label('nomor_bpjs', 'nomor_bpjs', ['class' => 'control-label']) !!}
      {!! Form::text('nomor_bpjs' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('nomor_bpjs'))<code>{!! $errors->first('nomor_bpjs') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('satisfaction_index')) has-error @endif">
      {!! Form::label('satisfaction_index', 'satisfaction_index', ['class' => 'control-label']) !!}
      {!! Form::text('satisfaction_index' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('satisfaction_index'))<code>{!! $errors->first('satisfaction_index') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('complaint')) has-error @endif">
      {!! Form::label('complaint', 'complaint', ['class' => 'control-label']) !!}
      {!! Form::text('complaint' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('complaint'))<code>{!! $errors->first('complaint') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('register_previously_saved_patient')) has-error @endif">
      {!! Form::label('register_previously_saved_patient', 'register_previously_saved_patient', ['class' => 'control-label']) !!}
      {!! Form::text('register_previously_saved_patient' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('register_previously_saved_patient'))<code>{!! $errors->first('register_previously_saved_patient') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('pasien_id')) has-error @endif">
      {!! Form::label('pasien_id', 'pasien_id', ['class' => 'control-label']) !!}
      {!! Form::text('pasien_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('pasien_id'))<code>{!! $errors->first('pasien_id') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('recovery_index_id')) has-error @endif">
      {!! Form::label('recovery_index_id', 'recovery_index_id', ['class' => 'control-label']) !!}
      {!! Form::text('recovery_index_id' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('recovery_index_id'))<code>{!! $errors->first('recovery_index_id') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('informasi_terapi_gagal')) has-error @endif">
      {!! Form::label('informasi_terapi_gagal', 'informasi_terapi_gagal', ['class' => 'control-label']) !!}
      {!! Form::text('informasi_terapi_gagal' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('informasi_terapi_gagal'))<code>{!! $errors->first('informasi_terapi_gagal') !!}</code>@endif
    </div>
    <div class="form-group @if($errors->has('menunggu')) has-error @endif">
      {!! Form::label('menunggu', 'menunggu', ['class' => 'control-label']) !!}
      {!! Form::text('menunggu' , null, ['class' => 'form-control rq']) !!}
      @if($errors->has('menunggu'))<code>{!! $errors->first('menunggu') !!}</code>@endif
    </div>
    {!! Form::close() !!}
@stop
@section('footer') 
    
@stop
