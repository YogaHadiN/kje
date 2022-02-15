@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pajak

@stop
@section('page-title') 
<h2>Laporan Pajak</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Pajak</strong>
	  </li>
</ol>

@stop
@section('content') 
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<div class="panelLeft">
						Lapor Pajak
					</div>
					<div class="panelRight">
						<a href="{{ url('pajaks/lapor_pajaks/create') }}" class="btn btn-info btn-sm" ><i class="fas fa-plus"></i> Create</a>
					</div>
				</h3>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>id</th>
								<th>Tanggal</th>
								<th>Staf</th>
								<th>Nilai</th>
								<th>Jenis Pajak</th>
								<th>Detail</th>
							</tr>
						</thead>
						<tbody>
							@if($lapor_pajaks->count() > 0)
								@foreach($lapor_pajaks as $lapor)
									<tr>
										<td>{{ $lapor->id }}</td>
										<td>{{ $lapor->tanggal_lapor }}</td>
										<td>{{ $lapor->staf->nama }}</td>
										<td class="uang">{{ $lapor->nilai }}</td>
										<td>{{ $lapor->jenisPajak->jenis_pajak }}</td>
										<td nowrap class="autofit">
											<a href="{{ url('pajaks/lapor_pajaks/'. $lapor->id) }}" target="_blank">Detil</a>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="6" class="text-center">Tidak ada Data</td>
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
