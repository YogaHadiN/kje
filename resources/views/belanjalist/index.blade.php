@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Janis Belanja

@stop
@section('head') 
<style type="text/css" media="all">
	a{
	color : #676A77;	
	}
	.belanja30 {
		width : 30% !important;
		height : 30% !important;
	}
	.belanja40 {
		width : 40% !important;
		height : 40% !important;
	}
	.belanja80 {
		width : 80% !important;
		height : 80% !important;
	}
</style>

@stop
@section('page-title') 
<h2>Janis Belanja</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Janis Belanja</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-lg-4">
		<a href="{{ url('fakturbelanjas/obat') }}">
			<div class="widget-head-color-box red-bg p-lg text-center">
				<div class="m-b-md">
					<h2 class="font-bold no-margins">
						Belanja<br />Persediaan Obat	
					</h2>
				</div>
				<img src="{{ \Storage::disk('s3')->url('img/pill.png') }}" class="belanja30" alt="profile">
				<div>
					<h4>Pengeluaran untuk membeli sesuatu yang akan mengurangi data stok saat transaksi customer</h4>
				</div>
			</div>
			<div class="widget-text-box">
				<h4 class="media-heading">Contoh : </h4>
				<ul>
					<li>Beli Lanamol di Apotek Berkat</li>
					<li>Beli Strip GDS di Arga Medika Pramuka dihitung per strip GDS</li>
					<li>Beli NaCl Kolf di Berkat</li>
					<li>Beli NaCl Kolf di Berkat</li>
				</ul>
			</div>
		</a>
	</div>
	<div class="col-lg-4">
		<a href="{{ url('suppliers/belanja_bukan_obat') }}">
			<div class="widget-head-color-box blue-bg p-lg text-center">
				<div class="m-b-md">
					<h2 class="font-bold no-margins">
						Belanja Lain-lain
					</h2>
				</div>
				<img src="{{ \Storage::disk('s3')->url('img/shop.png') }}" class="belanja40" alt="profile">
				<div>
					<h4>Pengeluaran untuk membeli sesuatu yang tidak bisa masuk dalam kategori yang lain</h4>
				</div>
			</div>
			<div class="widget-text-box">
				<h4 class="media-heading">Contoh : </h4>
				<ul>
					<li>Beli perangko</li>
					<li>Belanja Sayur Bibi</li>
					<li>Buat kirim ke JNE</li>
					<li>Uang Kemanan dan Sampah</li>
					<li>Beli Plastik</li>
				</ul>
			</div>
		</a>
	</div>
	<div class="col-lg-4">
		<a href="{{ url('pengeluarans/gojek') }}">
			<div class="widget-head-color-box navy-bg p-lg text-center">
				<div class="m-b-md">
					<h2 class="font-bold no-margins">
						GOJEK
					</h2>
				</div>
				<img src="{{ \Storage::disk('s3')->url('img/gojek.png') }}" class="belanja30" alt="profile">
				<div>
					<h4>Pengeluaran karena Menggunakan Aplikasi Gojek yang dibayar dengan GO PAY yang dibayar dari Klinik</h4>
				</div>
			</div>
			<div class="widget-text-box">
				<h4 class="media-heading">Contoh : </h4>
				<ul>
					<li>Biaya Antar Go Send Beli Kertas</li>
					<li>Biaya Antar Go Send Beli Obat ke Berkat</li>
					<li>Biaya transportasi karyawan karena perjalanan dinas</li>
					<li>Pengeluaran dengan Go Jek yang dibayar Cash TIDAK pakai fitur ini, tapi masuk ke belanja bukan obat</li>
				</ul>
			</div>
		</a>
	</div>
</div>

	
@stop
@section('footer') 
	
@stop


