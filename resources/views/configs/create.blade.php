@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Buat Informasi Baru

@stop
@section('page-title') 
<h2>Buat Informasi Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Informasi Baru</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open(['url' => 'configs', 'method' => 'post']) !!}
		@include('configs.form')
	{!! Form::close() !!}
@stop
@section('footer') 
{!! HTML::script('js/configs.js')!!}
@stop
