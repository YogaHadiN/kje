@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | ANC - {{ $periksa->pasien->nama }}

@stop
@section('page-title') 
<h2>Hasil Periksa Hamil</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pasiens')}}">Pasien</a>
      </li>
      <li>
          <a href="{{ url('pasiens/' . $periksa->pasien_id)}}">Riwayat Pemeriksaan</a>
      </li>
      <li class="active">
          <strong>ANC</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">{{ $periksa->id}} - {{ $periksa->pasien->nama }} | {{ $periksa->tanggal }}</div>
      </div>
      <div class="panel-body">
		  @include('ancs.form')
	  </div>
</div>


@stop
@section('footer') 
	
@stop
