@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pasien BPJS Dobel

@stop
@section('page-title') 
<h2>Pasien BPJS Dobel</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pasien BPJS Dobel</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Pasien Dobel Ditemukan {{ $pasiens->count() }} data</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Updated At</th>
								<th>Tanggal Lahir</th>
								<th>Alamat</th>
								<th>Nomor BPJS</th>
							</tr>
						</thead>
						<tbody>
							@if($pasiens->count() > 0)
								@foreach($pasiens as $k => $p)
									<tr>
										<td>{{ $k + 1 }}</td>
										<td nowrap>
											<a href="{{ url('pasiens/' . $p->id . '/edit') }}" target="_blank">{{ $p->nama }}</a>
										</td>
										<td nowrap>{{ $p->updated_at->format('d-m-Y') }}</td>
										<td nowrap>{{ $p->tanggal_lahir->format('d-m-Y') }}</td>
										<td>{{ $p->alamat }}</td>
										<td nowrap>{{ $p->nomor_asuransi_bpjs }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
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
