@extends('layout.master')

@section('title') 
Klinik Jati Elok | Gambar Estetika

@stop
@section('page-title') 
<h2>Gambar Estetika</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Gambar Estetika</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open([
		'url'		=> 'periksa/' . $periksa->id . '/images', 
		'method'	=> 'post', 
		'files'		=> 'true'
	]) !!}
	{!! Form::text('periksa_id', $periksa->id, ['class' => 'form-control hide']) !!}
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="panel panel-info">
					<div class="panel-heading">
					<div class="panel-title">Gambar Estetika | {{ $periksa->pasien->nama }}</div>
					</div>
					<div class="panel-body">
						<div id="panel_gambar">
							
						</div>
						@include('tambah_gambar')
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group">
					<button class="btn btn-success btn-block btn-lg" type="button" onclick="validasiKeterangan();return false;">Submit</button>
					{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
				</div> 
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a class="btn btn-danger btn-block btn-lg" href="{{ url('antrianperiksas') }}">Cancel</a>
			</div>
		</div>
	{!! Form::close() !!}
	@include('gambar_periksa')
@stop
@section('footer') 
{!! HTML::script('js/gambar_periksa.js')!!} 
<script type="text/javascript" charset="utf-8">
	tambahGambar();
	function dummySubmit(){
		 $('#submit').click();
	}
	
	
</script>
@stop
