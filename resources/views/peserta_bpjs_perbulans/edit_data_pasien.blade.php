@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Data Pasien RPPT

@stop
@section('page-title') 
<h2>Edit Data Pasien RPPT</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Data Pasien RPPT</strong>
	  </li>
</ol>

@stop
@section('content') 
	<h2>Terdapat {{ count($ht) + count($dm) }} Data yang harus dikoreksi</h2>
	<a href="#" class="float">
		<i class="fa fa-2x fa-object-group my-float"></i>
	</a>
	@include('peserta_bpjs_perbulans.form')
	@include('peserta_bpjs_perbulans.form', ['ht' => $dm])
	{!! Form::open(['url' => 'peserta_bpjs_perbulans', 'method' => 'post']) !!}
		{!! Form::text('bulanTahun', $bulanTahun, ['class' => 'form-control' , 'id' => 'bulanTahun']) !!}
		{!! Form::text('jumlah_dm', $jumlah_dm, ['class' => 'form-control']) !!}
		{!! Form::text('jumlah_ht', $jumlah_ht, ['class' => 'form-control']) !!}
		{!! Form::text('nama_file', $nama_file, ['class' => 'form-control']) !!}
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				{!! Form::submit('Update', ['class' => 'btn btn-success btn-block', 'id' => 'submit']) !!}
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
			</div>
		</div>
	{!! Form::close() !!}
@stop
@section('footer') 

{!! HTML::script('js/peserta_bpjs_perbulans_edit_data.js')!!}
	
@stop
