	@extends('layout.master')

	@section('title') 
	Klinik Jati Elok | Angka Kontak Belum Terpenuhi

	@stop
	@section('head') 
<style type="text/css" media="screen">
.cl-1 {
	width: 10%;
}
.cl-2 {
	width: 20%;
}
.cl-3 {
	width: 30%;
}
.cl-4 {
	width: 20% !important;
	word-wrap: break-word !important;
}
.cl-4 {
	width: 20%;
}
</style>
	@stop
	@section('page-title') 
	<h2>Angka Kontak Belum Terpenuhi</h2>
	<ol class="breadcrumb">
		  <li>
			  <a href="{{ url('laporans')}}">Home</a>
		  </li>
		  <li class="active">
			  <strong>Angka Kontak Belum Terpenuhi</strong>
		  </li>
	</ol>

	@stop
	@section('content') 
		
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th class="cl-1">No</th>
							<th class="cl-2">Nama</th>
							<th class="cl-3">Alamat</th>
							<th class="cl-4">No Telp</th>
							<th class="cl-5">No BPJS</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data) > 0)
							@foreach($data as $k => $d)
								<tr>
									<td class="cl-1">{{ $k + 1 }}</td>
									<td class="cl-2">{{ $d->nama_pasien }}</td>
									<td class="cl-3">{{ $d->alamat }}</td>
									<td class="cl-4">{{ $d->no_telp }}</td>
									<td class="cl-5">{{ $d->nomor_asuransi_bpjs }}</td>
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
				@stop
	@section('footer') 
		
	@stop
