@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Omset Estetika Per Bulan

@stop
@section('page-title') 
<h2>Omset Estetika Per Bulan</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Omset Estetika Per Bulan</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Omset Estetik Per Bulan</h3>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-hover table-condensed table-bordered">
							<thead>
								<tr>
									<th>Bulan</th>
									<th>Jumlah Pasien</th>
									<th>Omset</th>
								</tr>
							</thead>
							<tbody>
								@if(count($omsets) > 0)
									@foreach($omsets as $omset)
										<tr>
											<td>{{ $omset->bulan }}</td>
											<td class="text-right">
												{{ $omset->jumlah_pasien }}
											</td>
											<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $omset->tunai ) }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="3" class="text-center">
											Tidak ada data untuk ditampilkan
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	
@stop
			
