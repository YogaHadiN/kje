@extends('layout.master')

@section('title') 
	{{ \Auth::user()->tenant->name }} | Jumlah Pasien {{ $staf->nama }}

@stop
@section('page-title') 
	<h2>Jumlah Pasien {{ $staf->nama }}</h2>
<ol class="breadcrumb">
    <li>
        <a href="{{ url('laporans')}}">Home</a>
    </li>
    <li class="active">
        <strong>Jumlah Pasien {{ $staf->nama }}</strong>
    </li>
</ol>
@stop
@section('content') 
	<h1>Jumlah Pasien {{ $staf->nama }} {{ isset($tahun)? 'Tahun ' . $tahun : '' }}</h1>
    @if (isset($tahun))
      <a class="btn btn-info btn-lg" href="{{ url('stafs/' . $staf->id. '/jumlah_pasien/pertahun/' . $tahun. '/pdf') }}" target="_blank">PDF</a>
    @endif
	<hr>
	@include('stafs.tabel_jumlah')
@stop
@section('footer') 
	
@stop
