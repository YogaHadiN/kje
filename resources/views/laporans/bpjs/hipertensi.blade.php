@extends('layout.master')

@section('title') 
	Klinik Jati Elok | Laporan Hipertensi BPJS bulan {{ $bulan->format('M Y') }}

@stop
@section('page-title') 
<h2>Laporan Hipertensi BPJS bulan {{ $bulan->format('M Y') }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Hipertensi BPJS bulan {{ $bulan->format('M Y') }}</strong>
	  </li>
</ol>

@stop
@section('content') 

	<a class="btn btn-info btn-lg padding-10" href="{{ url('pdfs/bpjs/hipertensi/?bulanTahun=' . $bulan->format('m-Y')) }}" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> PDF</a>

		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered DT">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama</th>
						<th>Nomor</th>
						<th>Tekanan Darah</th>
					</tr>
				</thead>
				<tbody>
					@if(count($periksas) > 0)
						@foreach($periksas as $periksa)
							<tr>
								<td>{{ $periksa->tanggal }}</td>
								<td>{{ucwords( $periksa->nama_pasien )}}</td>
								<td>{{ $periksa->nomor_asuransi_bpjs }}</td>
								<td>{{ $periksa->sistolik }}
									@if( !empty( $periksa->sistolik ) && !empty($periksa->diastolik) )
										 / 
									@endif
									{{ $periksa->diastolik }} 
									@if( !empty( $periksa->sistolik ) && !empty($periksa->diastolik) )
										mmHg
									@endif
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		
@stop
@section('footer') 
	
@stop
