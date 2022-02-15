@extends('layout.master')

@section('title') 
Klinik Jati Elok | Piutang Asuransi Sudah Dibayar

@stop
@section('page-title') 
<h2>Piutang Asuransi Sudah Dibayar</h2>
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
		  <strong> Piutang Sudah Dibayar {{ date('d M y', strtotime( $mulai )) }} sampai {{ date('d M y', strtotime( $akhir )) }}</strong>
	  </li>
</ol>

@stop
@section('content') 

	<a class="btn btn-info btn-lg" href="{{ url('pdfs/piutang/sudah_dibayar/' . $asuransi->id . '/' . $mulai . '/'. $akhir) }}" target="_blank"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> PDF</a>

	<h1>{{ $asuransi->nama }}</h1>
	<h3> Piutang Sudah Dibayar {{ date('d M y', strtotime( $mulai )) }} sampai {{ date('d M y', strtotime( $akhir )) }} {{ count( $sudah_dibayars ) }} pasien</h3>

	<div>
	
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#piutang_sudah_dibayar" aria-controls="piutang_sudah_dibayar" role="tab" data-toggle="tab">Piutang Sudah Dibayar</a></li>
		<li role="presentation"><a href="#riwayat_pembayaran" aria-controls="riwayat_pembayaran" role="tab" data-toggle="tab">Riwayat Pembayaran Pelayanan Bulan  sampai {{ date('d M y', strtotime( $akhir )) }}</a></li>
	  </ul>
	
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="piutang_sudah_dibayar">
			@include('asuransis.sudah_dibayar_template')
		</div>
		<div role="tabpanel" class="tab-pane" id="riwayat_pembayaran">
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Tanggal Dibayar</th>
							<th>Staf</th>
							<th>Tanggal Input</th>
							<th>Dibayar ke</th>
							<th>Periode Pelayanan</th>
							<th>Jumlah Pembayaran</th>
						</tr>
					</thead>
					<tbody>
						@if(count($pembayaran_asuransi) > 0)
							@foreach($pembayaran_asuransi as $pa)
								<tr>
									<td>{{ $pa->tanggal_dibayar }}</td>
									<td>{{ $pa->nama_staf }}</td>
									<td>{{ date('d M y H:i:s', strtotime( $pa->tanggal_input )) }}</td>
									<td>{{ $pa->coa }}</td>
									<td>{{ date('d-m-Y', strtotime( $pa->mulai )) }} - {{ date('d-m-Y', strtotime( $pa->akhir )) }}</td>
									<td class="text-right"> 
										<a class="" href="{{ url('pembayaran_asuransis/' . $pa->id) }}">
											{{ App\Models\Classes\Yoga::buatrp( $pa->pembayaran ) }}
										</a>
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="">
									{!! Form::open(['url' => 'pembayaran_asuransi/imports', 'method' => 'post', 'files' => 'true']) !!}
										<div class="form-group">
											{!! Form::label('file', 'Data tidak ditemukan, upload data?') !!}
											{!! Form::file('file') !!}
											{!! Form::submit('Upload', ['class' => 'btn btn-primary', 'id' => 'submit']) !!}
										</div>
									{!! Form::close() !!}
								</td>
							</tr>
						@endif
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5"></td>
							<td>
								<h2> {{  App\Models\Classes\Yoga::buatrp( $total_pembayaran )  }}</h2>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	  </div>
	</div>
@stop
@section('footer') 
	
@stop

