@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Buat Denominator BPJS

@stop
@section('page-title') 
<h2>Buat Denominator BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Denominator BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				{!! Form::open(['url' => 'denominator_bpjs', 'method' => 'POST']) !!}
					@include('denominator_bpjs.form')
				{!! Form::close() !!}
			</div>
		</div>
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
