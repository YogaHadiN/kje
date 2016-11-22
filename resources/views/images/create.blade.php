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
		@include('images.form')
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
