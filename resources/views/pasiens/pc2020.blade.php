@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pacific Cross 2020

@stop
@section('page-title') 
<h2>Pacific Cross 2020</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pacific Cross 2020</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered DT">
				<thead>
					<tr>
						<th>Nomor</th>
						<th>Nama Pasien</th>
						{{-- <th>Nama Asuransi</th> --}}
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(count($pasiens) > 0)
						@foreach($pasiens as $key => $pasien)
							<tr>
								<td>{{ $key + 1 }}</td>
								<td>{{ $pasien->nama_pasien }}</td>
								{{-- <td>{{ $pasien->nama_asuransi }}</td> --}}
								<td nowrap class="autofit">
									<a href="{{ url('pasiens/' . $pasien->id) }}" class="btn btn-primary btn-sm" target="_blank">Riwayat</a>
									<a href="{{ url('pasiens/' . $pasien->id . '/edit') }}" class="btn btn-primary btn-sm" target="_blank">Edit</a>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4">Tidak ada data untuk ditampilkan</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		
@stop
@section('footer') 
	
@stop
