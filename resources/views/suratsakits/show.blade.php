@extends('layout.master')

@section('title') 
  {{ \Auth::user()->tenant->name }} | Riwayat Surat Sakit {{ $pasien->nama }}
@stop
@section('page-title') 
  <h2>Riwayat Surat Sakit {{$pasien->nama}}</h2>
<ol class="breadcrumb">
      <li>
        <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
        <strong>Riwayat Surat Sakit {{$pasien->nama}}</strong>
      </li>
</ol>

@stop
@section('content') 
  <h1>Riwayat Surat Sakit {{ $pasien->nama }}</h1>
  @include('suratsakits.table')
@stop
@section('footer') 
  
@stop
