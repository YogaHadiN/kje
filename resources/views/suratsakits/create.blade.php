@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buat Surat Sakit

@stop
@section('page-title') 
<h2>Buat Surat Sakit</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('ruangperiksas/' . $periksa->poli)}}">Antrian Periksa</a>
      </li>
      <li class="active">
          <strong>Buat Surat Sakit</strong>
      </li>
</ol>

@stop
@section('content') 
{!! Form::open(['url' => 'suratsakits', 'method' => 'post'])!!}
	@include('suratsakits.form', [
  'periksa_id' => $periksa->id,
  'nama' => $periksa->pasien->nama,
  'poli' => $periksa->poli,
  'submit' => 'Submit',
  'tanggal_mulai' => date('d-m-Y'),
  'hari' => '1',
  'delete' => false])
{!! Form::close()!!}
@stop
@section('footer') 
	
@stop