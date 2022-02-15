@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Per Tanggal

@stop
@section('page-title') 
 <h2>Laporan Per Tanggal</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Per Tanggal</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h3 class="panel-title">
								<div class="panelLeft">
									Pembayaran : {{ $nama_asuransi}}
								</div>	
								<div class="panelRight">
									{{ count($tanggal) }} pasien
								</div>
							</h3>
                      </div>
                      <div class="panel-body">
						  <div class="table-responsive">
								<table class="table table-bordered table-hover" id="tableAsuransi">
									  <thead>
										<tr>
											<th class="hide">ID</th>
											<th>Tanggal</th>
											<th>Nama</th>
											<th class="hide">Diagnosa</th>
											@foreach($rincian as $rinci)
											 <th> {!! $rinci !!}</th>
											 @endforeach
											<th>Tunai</th>
											<th>Piutang</th>
											<th>Modal Obat</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if (count($tanggal) > 0)
											@foreach ($tanggal as $key => $tgl)
											<tr>
												<td class="hide">{!! $tgl->periksa_id !!}</td>
												<td>{!! $tgl->created_at !!}</td>
												<td>{!! $tgl->nama !!} <br><br>
														id periksa : {!! $tgl->periksa_id !!}
														nama : {!! $tgl->diagnosaICD !!}

												</td>
												<td class="hide">{!! $tgl->diagnosaICD !!}</td>
												{!! App\Models\Classes\Yoga::jenisTarifs($tgl, $rincian)!!}
												<td class="uang">{!! $tgl->tunai !!}</td>
												<td class="uang">{!! $tgl->piutang !!}</td>
												<td class="uang">{!! $tgl->modal_obat !!}</td>
												<td><a href="{{ url('pdfs/kuitansi/' . $tgl->periksa_id ) }}">Kuitansi</a> | <a href="{{ url('pdfs/status/' . $tgl->periksa_id ) }}" target="_blank">Resep</a> | <a href="{{ url('periksas/' . $tgl->periksa_id ) }}">Detail</a></td>
											</tr>
											@endforeach
										@else
											<tr>
												<td colspan="6" class="text-center">Tidak / Belum ada transaksi</td>
											</tr>
										@endif
									</tbody>
									<tfoot>
										<tr>
											<th>Total</th>
											<th colspan="{!! count($rincian) !!}"></th>
											<td class="uang">{!! App\Models\Classes\Yoga::totalTunaiDetBulan($tanggal) !!}</td>
											<td class="uang">{!! App\Models\Classes\Yoga::totalPiutangDetBulan($tanggal) !!}</td>
											<td class="uang">{!! App\Models\Classes\Yoga::modalBulanIni($tanggall, $asuransi_id) !!}</td>
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
	
@stop
