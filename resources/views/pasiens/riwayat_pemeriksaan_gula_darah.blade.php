@extends('layout.master')

@section('title') 
	{{ \Auth::user()->tenant->name }} | Riwayat Pemeriksaan Gula Darah {{ ucwords($pasien->nama)}}

@stop
@section('page-title') 
<h2>
		Riwayat Pemeriksaan Gula Darah {{ ucwords( $pasien->nama)}}
 </h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
		Riwayat Pemeriksaan Gula Darah {{ ucwords( $pasien->nama)}}
	  <li class="active">
		  <strong>Riwayat </strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Gula Darah</th>
				</tr>
			</thead>
			<tbody>
				@if(count($data) > 0)
					@foreach($data as $d)
						<tr
						    @if ( $d->gula_darah >= 80 &&  $d->gula_darah <= 130  )
								class="success"
							@endif
							>
							<td>{{ $d->tanggal }}</td>
							<td>{{ $d->gula_darah }}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="2" class="text-center">Tidak ada data ditemukan</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
@stop
@section('footer') 
	
@stop
