@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Prolanis Terdaftar

@stop
@section('page-title') 
<h2>Prolanis Terdaftar</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Prolanis Terdaftar</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Prolanis Terdaftar</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>Nama Pasien</th>
							<th>Nomor BPJS</th>
							<th>Golongan Prolanis</th>
							<th>No HP</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($prolanis->count() > 0)
							@foreach($prolanis as $p)
								<tr>
									<td>{{ $p->pasien->nama }}</td>
									<td>{{ $p->pasien->nomor_asuransi_bpjs }}</td>
									<td>{{ $p->golonganProlanis }}</td>
									<td>{{ $p->pasien->no_telp }}</td>
									<td> <button class="btn btn-success btn-xs" type="button">button</button> </td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
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

