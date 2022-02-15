@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Peraturan Penyusutan

@stop
@section('page-title') 
<h2>Peraturan Penyusutan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Peraturan Penyusutan</strong>
	  </li>
</ol>
@stop
@section('content') 
@include('jurnal_umums.formPenyusutan')
@stop
@section('footer') 

@stop
