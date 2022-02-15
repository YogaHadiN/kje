@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Penjualan

@stop
@section('page-title') 
<h2>Edit Penjualan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Penjualan</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Edit Penjualan</h3>
	</div>
	<div class="panel-body">
		{{ $nota_jual->penjualan }}
	</div>
</div>	
@stop
@section('footer') 
	
@stop

