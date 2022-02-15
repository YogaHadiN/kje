@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Data Transaksi Go Pay

@stop
@section('page-title') 
<h2>Data Transaksi Go Pay</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Data Transaksi Go Pay</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">
				<div class="panelLeft">
					<h3>Data Transaksi Go Pay</h3>
				</div>
				<div class="panelRight">
					<h3> Saldo : {{ App\Models\Classes\Yoga::buatrp( $saldo ) }}</h3>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Menambah</th>
							<th>Mengurangi</th>
							<th>Petugas</th>
							<th>Keterangan</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($gopays->count() > 0)
							@foreach( $gopays as $g )
								<tr>
									<td>{{ $g->pengeluaran->tanggal->format('d M Y') }}</td>
									<td class="text-right">
										@if( $g->menambah )
											{{ App\Models\Classes\Yoga::buatrp( $g->nilai ) }}
										@else 
											0
										@endif
									</td>
									<td class="text-right">
										@if( $g->menambah )
											0
										@else 
											{{ App\Models\Classes\Yoga::buatrp( $g->menambah ) }}
										@endif
									</td>
									<td>{{ $g->pengeluaran->staf->nama }}</td>
									<td>{{ $g->pengeluaran->keterangan }}</td>
									<td>
										@if( $g->pengeluaran->faktur_image )
											<a class="btn btn-success btn-xs" target="_blank" href="{{ \Storage::disk('s3')->url('img/belanja/lain/' . $g->pengeluaran->faktur_image) }}">struk</a>
										@else
											<a class="btn btn-danger btn-xs" disabled href="">No Struk</a>
										@endif
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td class="text-center" colspan="">Tidak ada data untuk ditampilkan</td>
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
