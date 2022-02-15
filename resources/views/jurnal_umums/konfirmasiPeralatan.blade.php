@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Konfirmasi Peralatan

@stop
@section('page-title') 
<h2>Konfirmasi Peralatan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Konfirmasi Peralatan</strong>
	  </li>
</ol>
@stop
@section('head') 
<style type="text/css" media="all">
.table-alat tr td:nth-child(3),
.table-alat tr th:nth-child(3)
{
	width:15%;
}
.table-keterangan tr th:nth-child(3),
.table-keterangan tr td:nth-child(3){
	width:1px;
	white-space:nowrap;
}
.table-keterangan tr th:nth-child(2),
.table-keterangan tr td:nth-child(2){
	width:1px;
	white-space:nowrap;
}
</style>
@stop
@section('content') 
@include('jurnal_umums.formPenyusutan')
{!! Form::open(['url' => 'peralatans/konfirmasi', 'method' => 'post']) !!}
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-info">
			Nilai yang ada harus sesuai dengan peralatan
		</div>
	</div>
</div>
@foreach( $faktur_belanjas as $fb )
	@include('jurnal_umums.konfimasiForm', ['ikhtisar' => 'alat'])
@endforeach
<div class="row" id="danger_row" style="display:none;">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="alert alert-danger" id="danger_alert">
			
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<button class="btn btn-success btn-block btn-lg" type="button" onclick='dummySubmit();return false;'>Submit</button>
		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<a class="btn btn-danger btn-block btn-lg" href="{{ url('laporans') }}">Cancel</a>
	</div>
</div>
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
	</script>
{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
{!! Form::close() !!}
@stop
@section('footer') 
{!! HTML::script('js/notReady.js')!!}
{!! HTML::script('js/konfirmasiPeralatan.js')!!}
@stop
