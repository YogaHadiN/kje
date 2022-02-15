@extends('layout.master')
@section('title') 
{{ env("NAMA_KLINIK") }} | Bayar Dokter Gigi
@stop
@section('page-title') 
 <h2>Bayar Dokter Gigi</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Bayar Dokter Gigi</strong>
      </li>
</ol>
@stop
@section('content') 
{!! Form::open(['url' => 'pengeluarans/gaji_dokter_gigi/bayar', 'method' => 'post']) !!}
<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
          <div class="panel-body">
			  <h1>Bayar Gaji Dokter</h1>
            <hr>
			<div class="form-group @if($errors->has('staf_id'))has-error @endif">
			  {!! Form::label('staf_id', 'Nama Dokter Gigi Yang DiGaji', ['class' => 'control-label']) !!}
			  {!! Form::select('staf_id' , App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' =>'true']) !!}
			  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('sumber_uang_id'))has-error @endif">
			  {!! Form::label('sumber_uang_id', 'Sumber Uang', ['class' => 'control-label']) !!}
			  {!! Form::select('sumber_uang_id' , App\Models\Classes\Yoga::sumberCoaList(), 110004, ['class' => 'form-control']) !!}
			  @if($errors->has('sumber_uang_id'))<code>{{ $errors->first('sumber_uang_id') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('gaji_pokok'))has-error @endif">
			  {!! Form::label('gaji_pokok', 'Nilai', ['class' => 'control-label']) !!}
			  {!! Form::text('gaji_pokok' , null, ['class' => 'form-control uangInput']) !!}
			  @if($errors->has('gaji_pokok'))<code>{{ $errors->first('gaji_pokok') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('bulan'))has-error @endif">
			  {!! Form::label('bulan', 'Bulan Periode', ['class' => 'control-label']) !!}
			  {!! Form::text('bulan' , null, ['class' => 'form-control bulanTahun']) !!}
			  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('petugas_id'))has-error @endif">
			  {!! Form::label('petugas_id', 'Petugas Penginput', ['class' => 'control-label']) !!}
			  {!! Form::select('petugas_id' , App\Models\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
			  @if($errors->has('petugas_id'))<code>{{ $errors->first('petugas_id') }}</code>@endif
			</div>
			<div class="form-group @if($errors->has('tanggal_dibayar'))has-error @endif">
			  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar', ['class' => 'control-label']) !!}
			  {!! Form::text('tanggal_dibayar' , date('d-m-Y'), ['class' => 'form-control tanggal']) !!}
			  @if($errors->has('tanggal_dibayar'))<code>{{ $errors->first('tanggal_dibayar') }}</code>@endif
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

  @include('pengeluarans.tabel_bayar_dokter', ['bayar' => $gaji_gigis])

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

