@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Ikhtisarkan Bahan bangunan

@stop
@section('page-title') 
<h2>Ikhtisarkan Bahan bangunan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Ikhtisarkan Bahan bangunan</strong>
	  </li>
</ol>
@stop
@section('content') 
{!! Form::open(['url' => 'bahan_bangunans/ikhtisarkan', 'method' => 'post']) !!}
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Ikhtisarkan Bahan Bangunan</div>
		</div>
		<div class="panel-body">
			{!! Form::open(['url' => 'peralatans/konfirmasi', 'method' => 'post']) !!}
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="alert alert-info">
						Nilai yang ada harus sesuai dengan peralatan
					</div>
				</div>
			</div>
			@foreach( $pengeluarans as $fb )
				@include('jurnal_umums.konfimasiForm', ['ikhtisar' => 'bahan_bangunan'])
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
			{!! Form::text('route', $route, ['class' => 'form-control hide']) !!}
		</div>
	</div>
{!! Form::close() !!}
@stop
@section('footer') 
{!! HTML::script('js/notReady.js')!!}
{!! HTML::script('js/bahan_bangunan_ikhtisarkan.js')!!}
@stop
