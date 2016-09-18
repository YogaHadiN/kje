@extends('layout.master')

@section('title') 
Klinik Jati Elok | Janis Belanja

@stop
@section('head') 
<style type="text/css" media="all">
	a{
	color : #676A77;	
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
			<div class="widget-head-color-box navy-bg p-lg text-center">
				<div class="m-b-md">
					<h2 class="font-bold no-margins">
						Belanja<br />Persediaan Obat	
					</h2>
				</div>
				<img src="{{ url('img/pill.png') }}" class="" alt="profile" width="30%" height="30%">
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
		<a href="{{ url('pengeluarans/belanja/peralatan') }}">
			<div class="widget-head-color-box red-bg p-lg text-center">
				<div class="m-b-md">
					<h2 class="font-bold no-margins">
						Belanja Peralatan
					</h2>
				</div>
				<img src="{{ url('img/tool.png') }}" class="" alt="profile" width="40%" height="40%">
				<div>
					<h4>Pengeluaran untuk membeli sesuatu yang jumlahnya tidak berkurang dengan pemakaian</h4>
				</div>
			</div>
			<div class="widget-text-box">
				<h4 class="media-heading">Contoh : </h4>
				<ul>
					<li>Beli Klem Lurus / Klem Bengkok / Alat Medis Lain</li>
					<li>Beli Perabotan untuk klinik</li>
					<li>Beli Alat Elektronik Untuk Klinik (mis : Kalkulator, senter)</li>
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
				<img src="{{ url('img/shop.png') }}" class="" alt="profile" width="40%" height="40%">
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
</div>
	
@stop
@section('footer') 
	
@stop


