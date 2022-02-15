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
	<h1>Edit Surat</h1>
	{!! Form::model($surat,['url' => 'surats/' .  $surat->id, 'method' => 'put', 'files' => 'true']) !!}
		@include('surats.form')
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
