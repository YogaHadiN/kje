@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Laba Rugi

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
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
  <div class="panel panel-primary">
	  <div class="panel-heading">
		  <div class="panelLeft">
		  </div>
			<div class="panelRight">
				<a class="btn btn-warning" target="_blank" href="{{ url('pdfs/laporan_laba_rugi/' . $bulan . '/' . $tahun) }}">Bentuk PDF</a>
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
