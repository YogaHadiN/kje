@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Denominator {{ $prolanis }}

@stop
@section('page-title') 
<h2>Denominator {{ $prolanis }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Denominator {{ $prolanis }}</strong>
	  </li>
</ol>

@stop
@section('content') 
	<h2>{{ count($pasiens) }} Peserta {{ $prolanis }} Terdaftar Di Klinik</h2>
		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered DTa">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Usia</th>
						<th>No BPJS</th>
						<th>No Telp</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if($pasiens->count() > 0)
						@foreach($pasiens as $k => $p)
							<tr
								@if ( $p->sudah_kontak_bulan_ini )
									class="success"
								@endif
								>
								<td>{{ $k + 1 }}</td>
								<td>{{ $p->nama }}</td>
								<td>{{ $p->usia }} tahun</td>
								<td>{{ $p->nomor_asuransi_bpjs }}</td>
								<td>
									<a href="{{  wamehp($p->no_telp)  }}" target="_blank">{{ $p->no_telp }}</a>
								</td>
								<td nowrap class="autofit">
									<button class="btn btn-info btn-xs btn-block">Show</button>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan </td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
@stop
@section('footer') 
	
@stop
