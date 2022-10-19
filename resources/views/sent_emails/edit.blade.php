@extends('layout.master')

@section('title') 
Online Electronic Medical Record | Edit Pendaftaran

@stop
@section('page-title') 
<h2></h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('home')}}">home</a>
	  </li>
		<li>
		  <a href="{{ url('home/daftars')}}">Nurse Station</a>
	  </li>
	  <li class="active">
		  <strong>Edit</strong>
	  </li>
</ol>
@stop
@section('content') 
	<h1>{{ $daftar->pasien->nama }}</h1>
	{!! Form::model($daftar,['url' => 'home/daftars/' .  $daftar->id, 'method' => 'put']) !!}
		@include('daftars.form', ['update' => true])
	{!! Form::close() !!}
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
	</script>
@stop
