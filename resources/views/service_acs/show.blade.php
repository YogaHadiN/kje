@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Detil Service Ac

@stop
@section('page-title') 
<h2>Detil Service Ac</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Detil Service Ac</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Detil Service Ac</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed">
					<thead>
						<tr>
							<th>tanggal</th>
							<th>Supplier</th>
							<th>AC yang diservis</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($fakturbelanja->serviceAc->count() > 0)
							@foreach($fakturbelanja->serviceAc as $fb)
								<tr>
									<td>{{ $fb->tanggal->format('d-m-Y') }}</td>
									<td>{{ $fb->fakturBelanja->supplier->nama }}</td>
									<td>{{ $fb->keterangan }}</td>
									<td> <a class="btn btn-xs btn-warning" href="{{ url('') }}">Detail</a> </td>
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

