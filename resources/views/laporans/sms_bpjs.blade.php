@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan SMS BPJS

@stop
@section('page-title') 
<h2>Laporan SMS BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan SMS BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">Laporan SMS BPJS</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Nama Pasin</th>
							<th>Nomor BPJS</th>
							<th>Nomor HP</th>
							<th>Status Pengiriman</th>
							<th>Pesan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($sms_bpjs->count() > 0)
							@foreach($sms_bpjs as $sms)
								<tr>
									<td>{{ $sms->pasien->nama }}</td>
									<td>{{ $sms->pasien->no_telp }}</td>
									<td>{{ $sms->pasien->nomor_asuransi_bpjs }}</td>
									<td>{{ $sms->status_pengiriman }}</td>
									<td>{{ $sms->pesan }}</td>
									<td></td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="7">Tidak Ada Data Untuk Ditampilkan :p</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
	
@stop
@section('footer') 
	
@stop

