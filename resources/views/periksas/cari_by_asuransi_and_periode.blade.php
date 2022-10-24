@extends('layout.master')

@section('title') 
	{{ \Auth::user()->tenant->name }} | Cari Pemerikaan Asuransi {{ $asuransi->nama }}

@stop
@section('page-title') 
	<h2>Cari Pemerikaan Asuransi {{ $asuransi->nama }}</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cari Pemerikaan Asuransi {{ $asuransi->nama }}</strong>
	  </li>
</ol>
@stop
@section('content') 
<h1>{{ $asuransi->nama }}</h1>
<h3>{{ $from }} - {{ $until }}</h3>
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Tanggal Pelayanan</th>
					<th>Nama</th>
					<th>Asuransi</th>
					<th>Tunai</th>
					<th>Piutang</th>
					<th>Sudah Dibayar</th>
					<th>Sisa</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@php
					$total_piutang = 0;
					$total_tunai = 0;
					$total_sudah_dibayar = 0;
				@endphp
				@if($periksas->count() > 0)
					@foreach($periksas as $periksa)
						<tr>
							<td>
								<a href="{{ url('periksas/' . $periksa->id) }}" target="_blank">
									{{ Carbon\Carbon::parse($periksa->tanggal)->format('d-m-Y') }}
								</a>
							</td>
							<td>{{ $periksa->pasien->nama }}</td>
							<td>{{ $periksa->asuransi->nama }}</td>
							<td class="uang">{{ $periksa->tunai }}</td>
							<td class="uang">{{ $periksa->piutang }}</td>
							<td class="uang">{{ $periksa->sudah_dibayar }}</td>
							<td class="uang">{{ $periksa->piutang - $periksa->sudah_dibayar }}</td>
							<td nowrap class="autofit"></td>
						</tr>
						@php
							$total_piutang += $periksa->piutang;
							$total_tunai += $periksa->tunai;
							$total_sudah_dibayar  += $periksa->sudah_dibayar;
						@endphp
					@endforeach
				@else
					<tr>
						<td colspan="8">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3"></th>
					<th class="uang">{{ $total_tunai }}</th>
					<th class="uang">{{ $total_piutang }}</th>
					<th class="uang">{{ $total_sudah_dibayar }}</th>
					<th class="uang">{{ $total_piutang - $total_sudah_dibayar }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
@stop
@section('footer') 
	
@stop
