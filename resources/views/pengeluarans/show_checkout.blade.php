@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Checkout Detail

@stop
@section('page-title') 
<h2>Checkout Detail</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Checkout Detail</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Checkout Detail</div>
		</div>
		<div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="table-responsive">
					<table class='table table-condensed'>
						<tbody>
							<tr>
								<td>Tanggal Buka Kasir</td>
								<td>:</td>
								<td>{{ $buka_kasir->format('d-m-Y H:i:s') }}</td>
							</tr>
							<tr>
								<td>Tanggal Tutup Kasir</td>
								<td>:</td>
								<td>{{ $notaz->created_at->format('d-m-Y H:i:s') }}</td>
							</tr>
							<tr>
								<td>Uang di Kasir</td>
								<td>:</td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $notaz->uang_di_kasir ) }}</td>
							</tr>
							<tr>
								<td>Uang Masuk</td>
								<td>:</td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $notaz->uang_masuk ) }}</td>
							</tr>
							<tr>
								<td>Uang Keluar</td>
								<td>:</td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $notaz->uang_keluar ) }}</td>
							</tr>
							<tr>
								<td>Modal Awal</td>
								<td>:</td>
								<td>{{ App\Models\Classes\Yoga::buatrp( $notaz->modal_awal ) }}</td>
							</tr>
						</tbody>
					</table>
				</div>
				


            <div>
                <h4>Uang Keluar Dari Kasir</h4>
				<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<thead>
							<tr>
								<td>Tgl</td>
								<td>Penerima</td>
								<td>Biaya</td>
								<td>Jurnalable Type</td>
								<td>Detail</td>
							</tr>
						</thead>
						<tbody id="transaksi-print" class="font-small">
						  @foreach($pengeluarans as $plr)
							  <tr>
							  <td nowrap class="text-left">{{$plr->created_at->format('d-M')}}</td>
								  <td>
                                      @if ($plr->jurnalable_type == 'App\Models\FakturBelanja')
                                          @if (isset($plr->jurnalable->supplier['nama']))
                                          {{ $plr->jurnalable->supplier['nama'] }}
                                         @endif
                                      @elseif ($plr->jurnalable_type == 'App\Models\BayarDokter')
                                          {{ $plr->jurnalable->staf->nama }}
                                      @elseif ($plr->jurnalable_type == 'App\Models\Pengeluaran')
                                          {{ $plr->jurnalable->supplier['nama'] }}
                                      @elseif ($plr->jurnalable_type == 'App\Models\BayarGaji')
                                          {{ $plr->jurnalable->staf->nama }}
                                      @endif
                                  </td>
								  <td>{{ $plr->jurnalable_type }}</td>
								  <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
								  <td> <button class="btn btn-info btn-xs" type="button">detail</button> </td>
							  </tr>
						  @endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"><h3>Total Pengeluaran</h3></td>
								<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp($total_pengeluaran) }}</h3></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>

                <h4>Uang Keluar Dari Tangan</h4>
				<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<thead>
							<tr>
								<td>Tgl</td>
								<td>Penerima</td>
								<td>Biaya</td>
								<td>Jurnalable Type</td>
								<td>Detail</td>
							</tr>
						</thead>
						<tbody id="transaksi-print" class="font-small">
						  @foreach($pengeluarans_tangan as $plr)
							  <tr>
							  <td nowrap class="text-left">{{$plr->created_at->format('d-M')}}</td>
								  <td>
									  @if ($plr->jurnalable_type == 'App\Models\FakturBelanja')
										  @if (isset($plr->jurnalable->supplier['nama']))
										  {{ $plr->jurnalable->supplier['nama'] }}
										 @endif
									  @elseif ($plr->jurnalable_type == 'App\Models\BayarDokter')
										  {{ $plr->jurnalable->staf->nama }}
									  @elseif ($plr->jurnalable_type == 'App\Models\Pengeluaran')
										  {{ $plr->jurnalable->supplier['nama'] }}
									  @elseif ($plr->jurnalable_type == 'App\Models\BayarGaji')
										  {{ $plr->jurnalable->staf->nama }}
									  @elseif ($plr->jurnalable_type == 'App\Models\Modal')
										  Modal Masuk Ke Kasir
									  @endif
										  
									  </td>
								  <td>{{ $plr->jurnalable_type }}</td>
								  <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
								  <td> <button class="btn btn-info btn-xs" type="button">detail</button> </td>
							  </tr>
						  @endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3"><h3>Total Pengeluaran</h3></td>
								<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp($total_pengeluaran_tangan) }}</h3></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
                <h4>Modal Yang Masuk</h4>
				<div class="table-responsive">
					<table class="table table-condensed table-bordered">
						<thead>
							<tr>
								<td>Tanggal</td>
								<td>Keterangan</td>
								<td>Biaya</td>
								<td>Detail</td>
							</tr>
						</thead>
						<tbody id="transaksi-print" class="font-small">
						  @foreach($modals as $plr)
							  <tr>
								  <td>{{ $plr->created_at->format('d-M') }}</td>
								  <td>{{ $plr->coa->coa }}</td>
								  <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
								  <td> <button class="btn btn-info btn-xs" type="button">Detail</button> </td>
							  </tr>
						  @endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"><h3>Total Modal</h3></td>
								<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp($total_modal) }}</h3></td>
								<td></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
            </div>
        </div>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
        </script>
    </div>
	</div>
	
@stop
@section('footer') 
	
@stop

