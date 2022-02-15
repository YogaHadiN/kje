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
					<th>ID</th>
					<th>Nama</th>
					<th>Alamat</th>
					<th>No Telp</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if($pasien_rujuk_baliks->count() > 0)
					@foreach($pasien_rujuk_baliks as $pasien_rujuk_balik)
						<tr>
							<td>{{ $pasien_rujuk_balik->pasien_id }}</td>
							<td>{{ $pasien_rujuk_balik->pasien->nama }}</td>
							<td>{{ $pasien_rujuk_balik->pasien->alamat }}</td>
							<td>{{ $pasien_rujuk_balik->pasien->no_telp }}</td>
							<td nowrap class="autofit">Action</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="5" clas="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	
@stop
@section('footer') 
	
@stop

