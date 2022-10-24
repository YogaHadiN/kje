@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Pembayaran Asuransi Bulan {{ date('F Y', strtotime('01-' . $bulan . '-' . $tahun)) }}

@stop
@section('page-title') 
<h2>Pembayaran Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	<li>
		  <a href="{{ url('pembayaran_asuransis')}}">Pembayaran Asuransi</a>
	  </li>
	  <li class="active">
		  <strong>Pembayaran Asuransi {{ date('F Y', strtotime('01-' . $bulan . '-' . $tahun)) }}</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Bulan</th>
					<th>Nama Asuransi</th>
					<th>Dana masuk ke</th>
					<th>Jumlah Pembayaran</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if(count($pembayaran_asuransis) > 0)
					@foreach($pembayaran_asuransis as $pa)
						<tr>
							<td>{{ date('d M Y', strtotime( $pa->tanggal_dibayar )) }}</td>
							<td>{{ $pa->asuransi->nama }}</td>
							<td>{{ $pa->coa->coa }}</td>
							<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $pa->pembayaran ) }}</td>
							<td>
								<a class="btn btn-info btn-sm" href="{{ url('pembayaran_asuransis/' . $pa->id) }}">Info</a>
							</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="2" class="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
@stop
@section('footer') 
	
@stop

