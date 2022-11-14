@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Nota Pengeluaran Bukan Obat

@stop
@section('page-title') 
<h2>Nota Pengeluaran Bukan Obat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Nota Pengeluaran Bukan Obat</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Nota</div>
		</div>
		<div class="panel-body">
			<img src="{{ \Storage::disk('s3')->url('img/belanja/lain/'. $peng->faktur_image) }}" class="img-rounded upload" alt="Responsive image">
		</div>
	</div>
	
@stop
@section('footer') 
	
@stop

