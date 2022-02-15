@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | BPJS tidak pakai BPJS

@stop
@section('page-title') 
@section('head') 
	<style type="text/css" media="all">
table tr td:first-child, table tr th:first-child {
	width : 20%;
}

table tr td:nth-child(2), table tr th:nth-child(2) {
	width : 40%;
}
table tr td:nth-child(3),table tr th:nth-child(3) {
	width : 40%;
}
	</style>
@stop
<h2>BPJS tidak pakai BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>BPJS tidak pakai BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div>
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#belumProses" aria-controls="belumProses" role="tab" data-toggle="tab">Belum diProses</a></li>
			<li role="presentation"><a href="#sudahProses" aria-controls="sudahProses" role="tab" data-toggle="tab">Sudah Diproses</a></li>
		  </ul>
		
		  <!-- Tab panes -->
		  <div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="belumProses">
				<div class="panel panel-info">
					<div class="panel-heading">
					<div class="panel-title">Terdaftar {{ count($ks) }}</div>
					</div>
					<div class="panel-body">
						@include('laporans.form_bpjs_tidak_terpakai', ['ks' => $ks])
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="sudahProses">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Terdaftar {{ count($ksSubmit) }}</div>
					</div>
					<div class="panel-body">
						@include('laporans.form_bpjs_tidak_terpakai', ['ks' => $ksSubmit])
					</div>
				</div>
			
			</div>

		  </div>
		
		</div>
		
	</div>
</div>
@include('obat')
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		var base = '{{ url('/') }}';
		pcareSubmit()
	</script>
	{!! HTML::script('js/informasi_obat.js') !!}
@stop

