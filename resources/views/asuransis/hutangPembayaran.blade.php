@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Riwayat Hutang dan Pembayaran

@stop
@section('page-title') 
<h2>Riwayat Hutang dan Pembayaran</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Riwayat Hutang dan Pembayaran</strong>
	  </li>
</ol>
<style type="text/css" media="screen">
#table_pembayaran_asuransi th:nth-child(1), #table_pembayaran_asuransi td:nth-child(1) {
	width:10%;
}
#table_pembayaran_asuransi th:nth-child(2), #table_pembayaran_asuransi td:nth-child(2) {
	width:10%;
}
#table_pembayaran_asuransi th:nth-child(3), #table_pembayaran_asuransi td:nth-child(3) {
	width:10%;
}
#table_pembayaran_asuransi th:nth-child(4), #table_pembayaran_asuransi td:nth-child(4) {
	width:10%;
}
#table_pembayaran_asuransi th:nth-child(5), #table_pembayaran_asuransi td:nth-child(5) {
	width:10%;
}
#table_pembayaran_asuransi th:nth-child(6), #table_pembayaran_asuransi td:nth-child(6) {
	width:50%;
}
</style>
@stop
@section('content') 
	{!! Form::text('asuransi_id', $asuransi->id , ['class' => 'form-control hide', 'id' => 'asuransi_id']) !!}
	@include('asuransis.templateHutangPembayaran')
@stop
@section('footer') 

<script src="{!! url('js/get_transaksi_pembayaran_asuransi.js') !!}"></script>
<script src="{!! url('js/hutang_pembayaran.js') !!}"></script>
<script charset="utf-8">
	asuransiChange();
	asuransiChangeBulanan();
	getPembayaran();
</script>
@stop
