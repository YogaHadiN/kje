@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Cari Faktur Service Ac

@stop
@section('page-title') 
<h2>Cari Faktur Service Ac</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Cari Faktur Service Ac</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Faktur Service Ac</div>
		</div>
		<div class="panel-body">

			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Supplier</th>
							<th>AC yang diservis</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($fakturbelanjas->count() > 0)
							@foreach($fakturbelanjas as $fb)
								<tr>
									<td>{{ $fb->created_at->format('d-m-Y') }}</td>
									<td>{{ $fb->supplier->nama }}</td>
									<td>
										<ul>
											@foreach($fb->serviceAc as $ac)
												
												<li>AC No. {{ $ac->ac_id }} - {{ $ac->ac->keterangan }}</li>
										
											@endforeach
										</ul>
									</td>
									<td> <a class="btn btn-info btn-xs" href="{{ url('pengeluarans/service_acs/' . $fb->id) }}">Detail</a> </td>
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
	
