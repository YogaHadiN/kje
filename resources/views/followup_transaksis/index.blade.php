@extends('layout.master')

@section('title') 
Online Electronic Medical Record | Nurse Station

@stop
@section('page-title') 
<h2>Nurse Station</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('home')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Nurse Station</strong>
	  </li>
</ol>

@stop
@section('content') 
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Nama Pasien</th>
							<th>Poli</th>
							<th>Pembayaran</th>
							<th>Pemeriksa</th>
							<th>Waktu Terdaftar</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($daftars->count() > 0)
							@foreach($daftars as $daftar)
								<tr>
									<td>{{ $daftar->pasien->nama }}</td>
									<td>{{ $daftar->poli->poli }}</td>
									<td>{{ $daftar->asuransi->nama_asuransi }}</td>
									<td>{{ $daftar->staf->nama }}</td>
									<td>{{ $daftar->waktu }}</td>
									<td nowrap class="autofit">
										{!! Form::open(['url' => 'home/daftars/' . $daftar->id, 'method' => 'delete']) !!}
											<a class="btn btn-success btn-sm" href="{{ url('home/nursestation/' . $daftar->id . '/create') }}"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span></a>
											<a class="btn btn-warning btn-sm" href="{{ url('home/daftars/' . $daftar->id . '/edit') }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
											<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $daftar->pasien->nama }} dari daftar antrian ?')" type="submit"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="6" class="text-center">Tidak ada data ditemukan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
@stop
@section('footer') 
	
@stop

