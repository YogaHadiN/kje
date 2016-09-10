@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Belanja Bukan Obat

@stop
@section('page-title') 
<h2>Laporan Belanja Bukan Obat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Belanja Bukan Obat</strong>
	  </li>
</ol>

@stop
@section('head')
<style type="text/css" media="all">
	table td:first-child{
		width:1%;
	}
	.table tbody tr > td.success {
	  background-color: #dff0d8 !important;
	}

	.table tbody tr > td.error {
	  background-color: #f2dede !important;
	}

	.table tbody tr > td.warning {
	  background-color: #fcf8e3 !important;
	}

	.table tbody tr > td.info {
	  background-color: #d9edf7 !important;
	}

	.table-hover tbody tr:hover > td.success {
	  background-color: #d0e9c6 !important;
	}

	.table-hover tbody tr:hover > td.error {
	  background-color: #ebcccc !important;
	}

	.table-hover tbody tr:hover > td.warning {
	  background-color: #faf2cc !important;
	}

	.table-hover tbody tr:hover > td.info {
	  background-color: #c4e3f3 !important;
	}
</style>
@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Laporan Belanja Bukan Obat</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed DT">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Keterangan</th>
							<th>Petugas</th>
							<th>Nilai</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($peng->count() > 0)
							@foreach($peng as $p)
								<tr class="{{ $p->bgnota }}">
									<td>{{ $p->tanggal->format('d-m-Y') }}</td>
									<td>{{ $p->keterangan }}</td>
									<td nowrap>{{ $p->staf->nama }}</td>
									<td class="uang">{{ $p->nilai }}</td>
									<td> <a class="btn btn-{{ $p->warningnota }} btn-xs btn-block" href="{{ url('pengeluarans/belanja_bukan_obat/detail/' . $p->id) }}">{{ $p->adanota }}</a> </td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="6">Tidak Ada Data Untuk Ditampilkan :p</td>
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

