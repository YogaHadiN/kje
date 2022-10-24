@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Edit Informasi

@stop
@section('page-title') 
<h2>Edit Informasi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li>
		  <a href="{{ url('configs')}}">Pengaturan</a>
	  </li>
	  <li class="active">
		  <strong>Edit Informasi</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::model( $config, ['url' => 'configs', 'method' => 'post']) !!}
		@include('configs.form')
	{!! Form::close() !!}
@stop
@section('footer') 
{!! HTML::script('js/configs.js')!!}
@stop
