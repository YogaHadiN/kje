@extends('layout.master')

@section('title') 
Klinik Jati Elok | Buku Besar

@stop
@section('page-title') 
 <h2>List Buku Besar</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Buku Besar</strong>
      </li>
</ol>
@stop
@section('content') 
  <div class="panel panel-info">
    <div class="panel-heading">
		<h3 class="panel-title">
			<div class="panelLeft">
				Buku Besar : {{ $jurnalumums->first()->coa->coa }}
			</div>
			<div class="panelRight">
				<a class="btn btn-warning" target="_blank" href="{{ url('pdfs/buku_besar/' . $bulan . '/' . $tahun . '/' . $coa_id) }}">Bentuk PDF</a>
			</div>
		</h3>
    </div>
	<div class="panel-body">
	
		@include('buku_besars.form')
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
