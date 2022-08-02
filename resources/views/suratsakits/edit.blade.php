@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Surat Sakit

@stop
@section('page-title') 
<h2>Edit Surat Sakit</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('ruangperiksas/' . $suratsakit->periksa->poli_id)}}">Antrian Periksa</a>
      </li>
      <li class="active">
          <strong>Edit Surat Sakit</strong>
      </li>
</ol>

@stop
@section('content') 
{!! Form::model($suratsakit, ['url' => 'suratsakits/' . $suratsakit->id .'/' . $poli, 'method' => 'put'])!!}
	@include('suratsakits.form', ['submit' => 'Update', 'tanggal_mulai' => App\Models\Classes\Yoga::updateDatePrep($suratsakit->tanggal_mulai), 'hari' => $suratsakit->hari, 'delete' => true, 'periksa' => $suratsakit->periksa])
{!! Form::close()!!}
@stop
@section('footer') 
	
@stop
