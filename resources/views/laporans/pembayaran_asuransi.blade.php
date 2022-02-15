@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Pembayaran Asuransi
@stop
@section('page-title') 
 <h2>List Laporan Gaji Dokter</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Laporan Gaji Dokter</strong>
      </li>
</ol>
@stop
@section('content') 
{!! Form::open(['url' => 'pengeluarans/bayardokter/bayar', 'method' => 'get']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h1>Bayar Gaji Dokter</h1>
            <hr>
			<div class="form-group @if($errors->has('staf_id'))has-error @endif">
			  {!! Form::label('staf_id', 'Staf', ['class' => 'control-label']) !!}
              {!! Form::select('asuransi_id',$asuransi_list, null , ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
			  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('mulai'))has-error @endif">
			  {!! Form::label('mulai', 'Mulai', ['class' => 'control-label']) !!}
              {!! Form::text('mulai', null, ['class' => 'form-control rq tanggal']) !!}
			  @if($errors->has('mulai'))<code>{{ $errors->first('mulai') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('akhir'))has-error @endif">
			  {!! Form::label('akhir', 'Akhir', ['class' => 'control-label']) !!}
			  {!! Form::text('akhir', null, ['class' => 'form-control rq tanggal']) !!}
			  @if($errors->has('akhir'))<code>{{ $errors->first('akhir') }}</code>@endif
			</div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit(); return false;">Submit</button>
                      <button class="btn btn-success btn-block btn-lg hide" id="submit" type="submit">Submit</button>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                      <a href="{{ url('laporan_laba_rugis') }}" class="btn btn-danger btn-block btn-lg">Cancel</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
  </div>
</div>
{!! Form::close() !!}
@stop
@section('footer') 
<script>
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>

@stop

