@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Hutang Asuransi Per Bulan

@stop
@section('page-title') 
<h2>Hutang Asuransi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Hutang Asuransi bulan {{ App\Models\Classes\Yoga::bulan( $bulan ) }} {{ $tahun }}</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panelLeft">
						<div class="panel-title">Daftar Hutang per Bulan {{ $bulan }}-{{ $tahun }}</div>
					</div>
					<div class="panelRight">
					</div>
				</div>
				<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-condensed table-bordered">
								<thead>
									<tr>
										<th>Nama Asuransi</th>
										<th>Hutang</th>
										<th>Sudah Dibayar</th>
										<th>Kurang Bayar</th>
									</tr>
								</thead>
								<tbody>
									@if(count($data) > 0)
										@foreach( $data as $ar )
											<tr>
												<td>
													<a href="{{ url('asuransis/' . $ar->id . '/hutang/pembayaran') }}">
														{{ $ar->nama_asuransi }}</td>
													</a>

												<td class="text-right">
													<a href="{{ url('asuransis/' .$ar->id. '/piutangAsuransi/Semua/'. date('Y-m-01', strtotime($ar->tanggal)).'/' .date('Y-m-t', strtotime($ar->tanggal))) }}">
														{{App\Models\Classes\Yoga::buatrp( $ar->hutang ) }}
													</a>
												</td>
												<td class="text-right">
													<a href="{{ url('asuransis/' .$ar->id. '/piutangAsuransi/SudahDibayar/'. date('Y-m-01', strtotime($ar->tanggal)).'/' .date('Y-m-t', strtotime($ar->tanggal))) }}">
														{{App\Models\Classes\Yoga::buatrp( $ar->sudah_dibayar ) }}</td>
													</a>
												@if($ar->hutang - $ar->sudah_dibayar > 0 )
													<td class="text-right danger">
												@elseif($ar->hutang - $ar->sudah_dibayar < 0 )
													<td class="text-right success">
												@else
													<td class="text-right">
												@endif
														<a href="{{ url('asuransis/' .$ar->id. '/piutangAsuransi/BelumDibayar/'. date('Y-m-01', strtotime($ar->tanggal)).'/' .date('Y-m-t', strtotime($ar->tanggal))) }}">
															{{App\Models\Classes\Yoga::buatrp( $ar->hutang - $ar->sudah_dibayar ) }}
														</a>
													</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td class="text-center" colspan="">Tidak ada data untuk ditampilkan</td>
										</trasuransi_id
									@endif
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp( $total_hutang ) }}</h3></td>
										<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp( $total_sudah_dibayar ) }}</h3></td>
										<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp( $total_hutang - $total_sudah_dibayar ) }}</h3></td>
									</tr>
								</tfoot>
							</table>
						</div>
				</div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
  <script type="text/javascript" charset="utf-8">
	function dummySubmit(){
		if(validatePass()){
			$('#submit').click();
		}
	}
  </script>
@stop
