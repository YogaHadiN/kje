@extends('layout.master')
@section('title') 
Klinik Jati Elok | Bayar Dokter Gigi
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
			<div class="form-group" @if($errors->has('staf_id')) class="has-error" @endif)>
			  {!! Form::label('staf_id', 'Nama Dokter Gigi Yang DiGaji') !!}
			  {!! Form::select('staf_id' , App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' =>'true']) !!}
			  @if($errors->has('staf_id'))<code>{{ $errors->first('staf_id') }}</code>@endif
			</div>
			<div class="form-group" @if($errors->has('sumber_coa_id')) class="has-error" @endif)>
			  {!! Form::label('sumber_coa_id', 'Sumber Uang') !!}
			  {!! Form::select('sumber_coa_id' , App\Classes\Yoga::sumberCoaList(), 110004, ['class' => 'form-control']) !!}
			  @if($errors->has('sumber_coa_id'))<code>{{ $errors->first('sumber_coa_id') }}</code>@endif
			</div>
			<div class="form-group" @if($errors->has('nilai')) class="has-error" @endif)>
			  {!! Form::label('nilai', 'Nilai') !!}
			  {!! Form::text('nilai' , null, ['class' => 'form-control angka']) !!}
			  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
			</div>
			<div class="form-group" @if($errors->has('bulan')) class="has-error" @endif)>
			  {!! Form::label('bulan', 'Bulan Periode') !!}
			  {!! Form::text('bulan' , null, ['class' => 'form-control bulanTahun']) !!}
			  @if($errors->has('bulan'))<code>{{ $errors->first('bulan') }}</code>@endif
			</div>
			<div class="form-group" @if($errors->has('petugas_id')) class="has-error" @endif)>
			  {!! Form::label('petugas_id', 'Petugas Penginput') !!}
			  {!! Form::select('petugas_id' , App\Classes\Yoga::stafList(), null, ['class' => 'form-control selectpick', 'data-live-search' => 'true']) !!}
			  @if($errors->has('petugas_id'))<code>{{ $errors->first('petugas_id') }}</code>@endif
			</div>
			<div class="form-group" @if($errors->has('tanggal_dibayar')) class="has-error" @endif)>
			  {!! Form::label('tanggal_dibayar', 'Tanggal Dibayar') !!}
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
<div class="row">
	<?php echo $gaji_gigis->appends(Input::except('page'))->links(); ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Daftar Gaji Dokter Gigi</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Nama Dokter</th>
								<th>Jumlah Gaji</th>
								<th>Periode Bulan</th>
								<th>Tanggal Dibayar</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($gaji_gigis as $gaji)
								<tr>
									<td>{{ $gaji->staf->nama }}</td>
									<td class="uang">{{ $gaji->nilai }}</td>
									<td class="text-center">{{ $gaji->periode }}</td>
									<td class="text-center">{{ $gaji->tanggal_dibayar }}</td>
									<td> <a class="btn btn-info btn-xs btn-block" href="#" >struk</a> </td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php echo $gaji_gigis->appends(Input::except('page'))->links(); ?>
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

