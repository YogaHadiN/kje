@extends('layout.master')

@section('title') 
Klinik Jati Elok | Transaksi Pasien

@stop
@section('page-title') 
<h2>Transaksi Pasien</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Transaksi Pasien</strong>
	  </li>
</ol>

@stop
@section('content') 
	<h1>Transaksi <strong> <a href="{{ url('pasiens/' . $pasien->id . '/edit') }}" target="_blank"><span id="pasien_id">{{ $pasien->id }}</span> - {{ $pasien->nama }}</strong></a></h1>
<div class="table-responsive">
	<table class="table table-hover table-condensed table-bordered">
		<thead>
			<tr>
				<th>
					Tanggal Pemeriksaan
					<br>
					{!! Form::text('tanggal', null, [
						'class' => 'form-control',
						'id' => 'tanggal',
						'onkeyup' => 'getTransaksi(this); return false;',
					]) !!}
				</th>
				<th>Asuransi
					<br>
					{!! Form::text('tanggal', null, [
						'class' => 'form-control',
						'id' => 'nama_asuransi',
						'onkeyup' => 'getTransaksi(this); return false;',
					]) !!}
				</th>
				<th>Piutang
					<br>
					{!! Form::text('tanggal', null, [
						'class' => 'form-control',
						'id' => 'piutang',
						'onkeyup' => 'getTransaksi(this); return false;',
					]) !!}
				</th>
				<th>Tunai
					<br>
					{!! Form::text('tanggal', null, [
						'class' => 'form-control',
						'id' => 'tunai',
						'onkeyup' => 'getTransaksi(this); return false;',
					]) !!}
				</th>
				<th>Total</th>
				<th>Sudah Dibayar</th>
			</tr>
		</thead>
		<tbody id="container_transaksi">

		</tbody>
	</table>
</div>
@stop
@section('footer') 
	{!! HTML::script('js/pasien_transaksi.js')!!}
@stop
