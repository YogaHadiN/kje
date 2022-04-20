@extends('layout.master')

@section('title') 
Klinik Jati Elok | Verifikasi Data Prolanis

@stop
@section('page-title') 
<h2>Verifikasi Data Prolanis</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Verifikasi Data Prolanis</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div>

		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#dm" aria-controls="dm" role="tab" data-toggle="tab">Diabetes Mellitus</a></li>
			<li role="presentation"><a href="#ht" aria-controls="ht" role="tab" data-toggle="tab">Hipertensi</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="dm">
				@include('prolanis.form_verifikasi', [
					'prolanis'                        => $prolanisDm,
					'pasiens'                         => $pasienDm,
					'kategori_prolanis'               => 'dm',
					'verifikasi_prolanis_kategori_id' => 'verifikasi_prolanis_dm_id'
				])
			</div>
			<div role="tabpanel" class="tab-pane" id="ht">
				@include('prolanis.form_verifikasi', [
					'prolanis'                        => $prolanisHt,
					'pasiens'                         => $pasienHt,
					'kategori_prolanis'               => 'ht',
					'verifikasi_prolanis_kategori_id' => 'verifikasi_prolanis_ht_id'
				])
			</div>
		  </div>

		</div>
			

		
@stop
@section('footer') 
{!! HTML::script('js/verifikasi_prolanis.js')!!}
@stop
