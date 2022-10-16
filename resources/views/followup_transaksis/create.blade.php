@extends('layout.master')

@section('title') 

Online Electronic Medical Record | Pendaftaran

@stop
@section('page-title') 
<h2>Pendaftaran</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('home')}}">home</a>
	  </li>
	  <li class="active">
		  <strong></strong>
	  </li>
</ol>
@stop
@section('content') 
	<h1>{{ $pasien->nama }}</h1>
	{!! Form::open(['url' => 'home/daftars', 'method' => 'post']) !!}
		@include('daftars.form')
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
