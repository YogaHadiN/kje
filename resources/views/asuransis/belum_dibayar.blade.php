@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Piutang Asuransi Belum Dibayar

@stop
@section('page-title') 
<h2>Piutang Asuransi Belum Dibayar</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
		<li>
		  <a href="{{ url('asuransis')}}">Asuransi</a>
	  </li>
		<li>
			<a href="{{ url('asuransis/' . $asuransi->id)}}">{{ $asuransi->nama }}</a>
	  </li>
	  <li class="active">
		  <strong> Piutang Belum Dibayar {{ date('d M y', strtotime( $mulai )) }} sampai {{ date('d M y', strtotime( $akhir )) }}</strong>
	  </li>
</ol>

@stop
@section('content') 

	<a class="btn btn-info btn-lg" href="{{ url('pdfs/piutang/belum_dibayar/' . $asuransi->id . '/' . $mulai . '/'. $akhir) }}" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> PDF</a>
	<h1>{{ $asuransi->nama }}</h1>
	<h3> Piutang Belum Dibayar {{ date('d M y', strtotime( $mulai )) }} sampai {{ date('d M y', strtotime( $akhir )) }} {{ count( $belum_dibayars ) }} pasien</h3>
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered ">
			<thead>
				<tr>
					<th>No</th>
					<th>Invoice ID</th>
					<th>Tanggal</th>
					<th>Nama</th>
					<th>Piutang</th>
					<th>Sudah dibayar</th>
					<th>Sisa Piutang</th>
				</tr>
			</thead>
			<tbody>
				@if(count($belum_dibayars) > 0)
					@foreach($belum_dibayars as $k => $belum)
						<tr>
							<td>{{ $k +1 }}</td>
							<td>
								<a href="{{ url('invoices/' .   $belum->invoice_id ) }}" target="_blank">
									{{ $belum->invoice_id }}
								</a>
							</td>
							<td>
								<a class="" href="{{ url('periksas/' . $belum->periksa_id) }}">
									{{ date('d M y', strtotime( $belum->tanggal )) }}
								</a>
							</td>
							<td>
								<a class="" href="{{ url('pasiens/' . $belum->pasien_id . '/edit') }}">
									{{ $belum->nama_pasien }}</td>
								</a>
							<td class="text-right uang"> {{$belum->piutang}}</td>
							<td class="text-right">
								<a class="uang" href="{{ url('pembayaran_asuransis/' . $belum->pembayaran_asuransi_id) }}">
								 {{ $belum->total_pembayaran }}
								</a>
							</td>
							<td class="text-right uang"> {{ $belum->piutang  - $belum->total_pembayaran }}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4"></td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_sisa_piutang ) }}</h2>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	
	
@stop
@section('footer') 
	
@stop

