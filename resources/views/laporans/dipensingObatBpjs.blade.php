@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Dispensing Obat BPJS

@stop
@section('page-title') 
<h2>Laporan Dispensing Obat BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan Dispensing Obat BPJS</strong>
	  </li>
</ol>
@stop
@section('content') 
<div class="row">
	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Laporan Dispensing Obat BPJS</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover table-condensed table-bordered">
						<thead>
							<tr>
								<th>Nama Dokter</th>
								<th>Total Harga Beli Obat</th>
								<th>Total Harga Jual Obat</th>
								<th>Jumlah Pasien BPJS</th>
								<th>Dispensing/Pasien</th>
							</tr>
						</thead>
						<tbody>
							@if(count($array) > 0)
								@foreach( $array as $a )
									<tr>
										<td>{{ $a['nama_staf'] }}</td>
										<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $a['jumlah_harga_beli'] ) }}</td>
										<td class="text-right">{{App\Models\Classes\Yoga::buatrp($a['jumlah_harga_jual'])  }}</td>
										<td class="text-right">{{ $a['jumlah_pasien'] }}</td>
										<td class="text-right">{{App\Models\Classes\Yoga::buatrp($a['dispensing_per_pasien'])}}</td>
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
