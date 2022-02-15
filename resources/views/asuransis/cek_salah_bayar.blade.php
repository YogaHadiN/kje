@extends('layout.master')

@section('title') 
Klinik Jati Elok | Cek Salah Bayar

@stop
@section('page-title') 
<h2>Cek Salah Bayar</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cek Salah Bayar</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered DTa">
				<thead>
					<tr>
						<th>pembayaran_id</th>
						<th>tanggal dibayar</th>
						<th>Nilai di rekening</th>
						<th>Pembayaran</th>
						<th>Selisih</th>
						<th>Nama Asuransi</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pembayarans as $pembayaran)
						<tr>
							<td>{{ $pembayaran->id }}</td>
							<td>{{ $pembayaran->tanggal_dibayar }}</td>
							<td>{{ $pembayaran->nilai }}</td>
							<td>{{ $pembayaran->pembayaran }}</td>
							<td>{{  $pembayaran->nilai - $pembayaran->pembayaran }}</td>
							<td>{{ $pembayaran->nama_asuransi }}</td>
							<td nowrap class="autofit"></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
@stop
@section('footer') 
	
@stop
