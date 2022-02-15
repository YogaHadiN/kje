@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pasien Rujuk Balik

@stop
@section('page-title') 
<h2>Pasien Rujuk Balik</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pasien Rujuk Balik</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Nama Pasien</th>
					<th>Nomor Telepon</th>
					<th>Alamat</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if($pasiens->count() > 0)
					@foreach($pasiens as $pasien)
						@if( in_array($pasien->id, $periksa_bulan_ini_pasien_ids) )
							<tr class="success">
						@else
							<tr class="danger">
						@endif
							<td>{{ $pasien->nama }}</td>
							<td>{{ $pasien->no_telp }}</td>
							<td>{{ $pasien->alamat }}</td>
							<td nowrap class="autofit">

							</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="3">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	
@stop
@section('footer') 
	
@stop

