@extends('layout.master')

@section('title') 
Klinik Jati Elok | Catatan Asuransi

@stop
@section('page-title') 
<h2>Catatan Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Catatan Asuransi</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Nama Peserta</th>
					<th>Tagihan</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if($catatans->count() > 0)
					@foreach($catatans as $catatan)
						<tr>
							<td>{{ $catatan->peserta }}</td>
							<td>{{ $catatan->tagihan }}</td>
							<td nowrap class="autofit"></td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="3">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	
@stop
@section('footer') 
	
@stop

