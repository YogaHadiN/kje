@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Pasien Baru

@stop
@section('page-title') 
<h2>Buat Pasien Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Pasien Baru</strong>
	  </li>
</ol>

@stop
@section('content') 

		{!! Form::open([
				'url' => 'antrianpolis/pengantar/pasien/create', 
				'files' => 'true', 
				'method' => 'post'
			]) !!}
				@include('pasiens.createForm', ['antrianpolis' => false])

			{!! Form::close() !!}
	
@stop
@section('footer') 
	
	{!! HTML::script('js/plugins/webcam/photo.js')!!}
	{!! HTML::script('js/togglepanel.js')!!}
	{!! HTML::script('js/pasiens.js')!!}
	{!! HTML::script('js/peringatan_usg.js')!!}
@stop

