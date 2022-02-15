@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Laba Rugi

@stop
@section('page-title') 
 <h2>List Laporan Laba Rugi</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>List Laporan Laba Rugi</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
  <div class="panel panel-primary">
	  <div class="panel-heading">
		  <div class="panelLeft">
		  </div>
			<div class="panelRight">
				@if ($bikinan)
					<a class="btn btn-warning" target="_blank" href="{{ url('pdfs/laporan_laba_rugi/bikinan/' . $tanggal_awal . '/' . $tanggal_akhir) }}">Bentuk PDF</a>
				@else
					<a class="btn btn-warning" target="_blank" href="{{ url('pdfs/laporan_laba_rugi/' . $tanggal_awal . '/' . $tanggal_akhir) }}">Bentuk PDF</a>
				@endif
		  </div>
	  </div>
	  <div class="panel-body">
		  @include('laporan_laba_rugis.form')
	  </div>
      </div>
    </div>
  </div>
@stop
@section('footer') 
<script>
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>
@stop
