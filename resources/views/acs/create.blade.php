@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat AC baru

@stop
@section('page-title') 
<h2>Buat AC baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat AC baru</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open([
		'url' => 'acs', 
		'method' => 'post',
		"class" => "m-t", 
		"role"  => "form",
		"files"=> true
	]) !!}
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Buat AC baru</div>
		</div>
		<div class="panel-body">
			@include('acs.form')
		</div>
	</div>
	
	{!! Form::close() !!}
@stop
@section('footer') 
	
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
@stop
					
