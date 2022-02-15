@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Entri Beli Obat

@stop
@section('page-title') 
<h2>Riwayat Pembelian</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pembelians.riwayat')}}">Riwayat</a>
      </li>
      <li class="active">
          <strong>Detail</strong>
      </li>
</ol>

@stop
@section('content') 

	@if($fakturbelanja->belanja_id == '4')
		@include('pembelians.show_alat')
	@else
		@include('pembelians.show_obat')
	@endif

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Jurnal Umum</h3>
	</div>
	<div class="panel-body">
		@include('jurnal_umums.jurnal_template')
	</div>
</div>
@include('obat')
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		var base = '{{ url("/") }}';
	</script>
	{{ HTML::script('js/informasi_obat.js') }}
@stop
