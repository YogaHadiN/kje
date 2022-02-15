@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pelaporan Amortisasi

@stop
@section('page-title') 
<h2>Pelaporan Amortisasi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pelaporan Amortisasi</strong>
	  </li>
</ol>
@stop
@section('content') 

	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					{{-- <th>id</th> --}}
					<th>jenis harta</th>
					<th>kelompok harta</th>
					<th>jenis usaha</th>
					<th>nama harta</th>
					<th>bulan perolehan</th>
					<th>tahun perolehan</th>
					{{-- <th>tanggal perolehan</th> --}}
					<th>jenis penyusutan komersial</th>
					<th>jenis penyusutan fiskal</th>
					<th>harga perolehan</th>
					<th>nilai sisa buku</th>
					<th>penyusutan fiskal tahun ini</th>
					<th>keterangan nama harta</th>
				</tr>
			</thead>
			<tbody>
				@php( $total_penyusutan = 0 )
				@foreach($datas as $d)
					<tr>
						{{-- <td>{{ $d->id }}</td> --}}
						<td>{{ $d->jenis_harta }}</td>
						<td>{{ $d->kelompok_harta }}</td>
						<td>{{ $d->jenis_usaha }}</td>
						<td>{{ $d->nama_harta }}</td>
						<td>{{ $d->bulan_perolehan }}</td>
						<td>{{ $d->tahun_perolehan }}</td>
						{{-- <td>{{ $d->tanggal_perolehan }}</td> --}}
						<td>{{ $d->jenis_penyusutan_komersial }}</td>
						<td>{{ $d->jenis_penyusutan_fiskal }}</td>
						<td>{{ $d->harga_perolehan }}</td>
						<td>{{ $d->nilai_sisa_buku }}</td>
						<td>{{ $d->penyusutan_fiskal_tahun_ini }}</td>
						<td>{{ $d->keterangan_nama_harta }}</td>
					</tr>
					@php( $total_penyusutan += $d->penyusutan_fiskal_tahun_ini )
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan="10"></td>
					<td>{{ $total_penyusutan }}</td>
					<td></td>
				</tr>
			</tfoot>
		</table>
		
	</div>
@stop
@section('footer') 

@stop		
