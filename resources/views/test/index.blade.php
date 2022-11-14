@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Test

@stop
@section('page-title') 
<h2></h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Test</strong>
	  </li>
</ol>
@stop

@section('content') 
	<h1>gambar</h1>
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<img src="{{ url('qrcode') }}" alt="">
			</div>
		</div>
@stop
@section('footer') 

@stop
