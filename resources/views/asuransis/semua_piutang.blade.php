@extends('layout.master')

@section('title') 
	Klinik Jati Elok | Piutang Asuransi {{ $asuransi->nama }} 

@stop
@section('page-title') 
	<h2>Piutang Asuransi {{ $asuransi->nama }}</h2>
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
		  <strong>Semua Piutang tanggal {{ date('d F Y', strtotime( $mulai )) }} sampai {{ date('d F Y', strtotime( $akhir )) }} </strong>
	  </li>
</ol>

@stop
@section('content') 
	<a class="btn btn-info btn-lg" href="{{ url('pdfs/piutang/semua/' . $asuransi->id . '/' . $mulai . '/'. $akhir) }}" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> PDF</a>
	<h1>Semua Piutang tanggal {{ date('d F Y', strtotime( $mulai )) }} sampai {{ date('d F Y', strtotime( $akhir )) }} </h1>
	<h2>{{ count($piutangs) }} Pasien</h2>
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-bordered ">
			<thead>
				<tr>
					<th>Tanggal Periksa</th>
					<th>Nama</th>
					<th>Tunai</th>
					<th>Piutang</th>
					<th>Sudah Dibayar</th>
					<th>Sisa Piutang</th>
				</tr>
			</thead>
			<tbody>
				@if(count($piutangs) > 0)
					@foreach($piutangs as $p)
						<tr>
							<td>{{ date('d M y', strtotime( $p->tanggal_periksa )) }}</td>
							<td>
								<a class="" href="{{ url('periksas/' . $p->periksa_id) }}">
									{{ $p->nama_pasien }}</td>
								</a>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->tunai) }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->piutang) }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->sudah_dibayar) }}</td>
							<td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($p->piutang  - $p->sudah_dibayar) }}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2"></td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_tunai ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</h2>
					</td>
					<td class="text-right">
						<h2> {{ App\Models\Classes\Yoga::buatrp( $total_piutang - $total_sudah_dibayar ) }}</h2>
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
	
	
@stop
@section('footer') 
	
@stop

