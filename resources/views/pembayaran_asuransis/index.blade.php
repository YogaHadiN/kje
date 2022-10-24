@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Pembayaran Asuransi

@stop
@section('page-title') 
<h2>Pembayaran Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Pembayaran Asuransi</strong>
	  </li>
</ol>

@stop
@section('content') 
	<h1>Pembayaran Asuransi Menurut Tanggal Dibayar</h1>
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered DTs">
					<thead>
						<tr>
							<th>Bulan Dibayar</th>
							<th>Jumlah Pembayaran</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($pembayaran_asuransis) > 0)
							@foreach($pembayaran_asuransis as $pa)
								<tr>
									<td>{{ date('M Y', strtotime( $pa->created_at )) }}</td>
									<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $pa->total_pembayaran ) }}</td>
									<td>
										<a class="btn btn-info btn-sm" href="{{ url('pembayaran_asuransis/' . date('m', strtotime( $pa->created_at )) . '/' .date('Y', strtotime( $pa->created_at )) ) }}">Info</a>
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
		</div>
	</div>
@stop
@section('footer') 
	
@stop

