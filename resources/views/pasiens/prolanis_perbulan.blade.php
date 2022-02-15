@extends('layout.master')

@section('title') 
Klinik Jati Elok | Prolanis Bulan {{ $bulanTahun }}

@stop
@section('page-title') 
<h2>Prolanis Bulan {{ $bulanTahun }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Prolanis Bulan {{ $bulanTahun }}</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#prolanis_ht" aria-controls="prolanis_ht" role="tab" data-toggle="tab">Hipertensi</a></li>
			<li role="presentation"><a href="#prolanis_dm" aria-controls="prolanis_dm" role="tab" data-toggle="tab">Diabetes</a></li>
		  </ul>
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="prolanis_ht">
				<a href="{{ url('pdfs/prolanis_hipertensi_perbulan/'. $tahunBulan ) }}" class="btn btn-primary btn-lg" target="_blank">PDF</a>
				@include('pasiens.prolanis_perbulan_template', [  'prolanis' => 'prolanis_ht', 'bukan_pdf' => true])
			</div>
			<div role="tabpanel" class="tab-pane" id="prolanis_dm">
				<a href="{{ url('pdfs/prolanis_dm_perbulan/'. $tahunBulan ) }}" class="btn btn-primary btn-lg" target="_blank">PDF</a>
				@include('pasiens.prolanis_perbulan_template', ['prolanis' => 'prolanis_dm', 'bukan_pdf' => true])
			</div>
		  </div>

		</div>
		
@stop
@section('footer') 
	
@stop
