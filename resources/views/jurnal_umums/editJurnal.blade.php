@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Jurnal Periksa

@stop
@section('page-title') 
<h2>Edit Jurnal Periksa</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Jurnal Periksa</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Edit Jurnal Periksa</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				@include('periksas.jurnal')
			</div>
		</div>
	</div>
	
@stop
@section('footer') 
	
@stop

