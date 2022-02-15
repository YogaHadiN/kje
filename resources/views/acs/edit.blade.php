@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Air Conditioner

@stop
@section('page-title') 
<h2>Edit Air Conditioner</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Air Conditioner</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::model($ac,[
			'url' => 'acs/' . $ac->id, 
		'method' => 'put',
		"class" => "m-t", 
		"role"  => "form",
		"files"=> true
	]) !!}
		
	
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Edit AC</div>
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

