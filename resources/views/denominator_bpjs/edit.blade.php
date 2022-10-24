@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Edit Denominator BPJS

@stop
@section('page-title') 
<h2>Edit Denominator BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Denominator BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::model( $denominator_bpjs, ['url' => 'denominator_bpjs', 'method' => 'PUT']) !!}
		@include('denominator_bpjs.form')
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
