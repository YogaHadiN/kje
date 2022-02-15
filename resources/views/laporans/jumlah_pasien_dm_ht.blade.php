@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pasien DM dan HT Bulan {{ $bulanTahun }}

@stop
@section('page-title') 
<h2>Laporan Pasien DM dan HT Bulan {{ $bulanTahun }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Pasien DM dan HT Bulan {{ $bulanTahun }}</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div>
	
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#ht" aria-controls="ht" role="tab" data-toggle="tab">Hipertensi</a></li>
		<li role="presentation"><a href="#dm" aria-controls="dm" role="tab" data-toggle="tab">Diabetes</a></li>
	  </ul>
	
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="ht">
			@include('laporans.form.htBulanan', ['data' => $data['ht']])
		</div>
		<div role="tabpanel" class="tab-pane" id="dm">
			@include('laporans.form.htBulanan', ['data' => $data['dm']])
		</div>
	  </div>
	</div>
@stop
@section('footer') 
	
@stop

