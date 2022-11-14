@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Faktur Belanja

@stop
@section('page-title') 
<h2>Faktur Belanja</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Faktur Belanja</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Faktur Belanja Service Ac</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Id</th>
							<th>Ac yang diservice</th>
							<th>Supplier</th>
						</tr>
					</thead>
					<tbody>
						@if($fakturbelanja->serviceAc->count() > 0)
							@foreach($fakturbelanja->serviceAc as $service)
								<tr>
									<td>{{ $service->id }}</td>
									<td> Ac No. {{ $service->ac_id }} - {{ $service->ac->keterangan }}</td>
									<td>{{ $service->fakturBelanja->supplier->nama }}</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
			<div>
				<img src="{{ \Storage::disk('s3')->url('img/belanja/serviceAc/' . $fb->img) }}" class="img-responsive,img-rounded,img-circle,img-thumbnail" alt="Responsive image">
				
			</div>
			
		</div>
	</div>
	
@stop
@section('footer') 
	
@stop

