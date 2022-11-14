<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Nota Z</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center border-bottom">
                    <h1>{{ ucwords( \Auth::user()->tenant->name ) }}</h1>
                    <h5>
                        {{ ucwords( \Auth::user()->tenant->address ) }} <br>
                        Telp : {{ \Auth::user()->tenant->no_telp }}  
                    </h5>
                    <h3 class="border-top">Nota Z</h3>
                </div>
            <div class="box border-bottom">
                <table>
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
					<table class="table table-condensed bordered">
						<thead>
							<tr>
								<td>Tgl</td>
								<td>Penerima</td>
								<td>Biaya</td>
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
											  @if (isset($plr->jurnalable->supplier['nama']))
											  {{ $plr->jurnalable->supplier['nama'] }}
											 @endif
										  @elseif ($plr->jurnalable_type == 'App\Models\BayarGaji')
											  {{ $plr->jurnalable->staf->nama }}
										  @endif
										  
									  </td>
								  <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
							  </tr>
						  @endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"><h3>Total Pengeluaran</h3></td>
								<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp($total_pengeluaran) }}</h3></td>
							</tr>
						</tfoot>
					</table>
				</div>

                <h4>Uang Keluar Dari Tangan</h4>
				<div class="table-responsive">
					<table class="table table-condensed bordered">
						<thead>
							<tr>
								<td>Tgl</td>
								<td>Penerima</td>
								<td>Biaya</td>
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
										  @if (isset($plr->jurnalable->supplier['nama']))
										  {{ $plr->jurnalable->supplier['nama'] }}
										 @endif
									  @elseif ($plr->jurnalable_type == 'App\Models\BayarGaji')
										  {{ $plr->jurnalable->staf->nama }}
									  @elseif ($plr->jurnalable_type == 'App\Models\Modal')
										  Modal Masuk Ke Kasir
									  @endif
										  
									  </td>
								  <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
							  </tr>
						  @endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"><h3>Total Pengeluaran</h3></td>
								<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp($total_pengeluaran_tangan) }}</h3></td>
							</tr>
						</tfoot>
					</table>
				</div>
                <h4>Modal Yang Masuk</h4>
				<div class="table-responsive">
					<table class="table table-condensed bordered">
						<thead>
							<tr>
								<td>Tanggal</td>
								<td>Keterangan</td>
								<td>Biaya</td>
							</tr>
						</thead>
						<tbody id="transaksi-print" class="font-small">
						  @foreach($modals as $plr)
							  <tr>
							  <td>{{ $plr->created_at->format('d-M') }}</td>
							  <td>{{ $plr->coa->coa }}</td>
								  <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
							  </tr>
						  @endforeach
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"><h3>Total Modal</h3></td>
								<td class="text-right"><h3>{{ App\Models\Classes\Yoga::buatrp($total_modal) }}</h3></td>
							</tr>
						</tfoot>
					</table>
				</div>
                <div class="text-center">
					<div class="table-responsive">
						<table class="table-center">
							<tbody class="text-center">
								<tr class="border-top">
									<td>Dikosongkan Oleh</td>
									<td>Saksi Oleh</td>
								</tr>
								<tr class="tanda-tangan">
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>( .................... )</td>
									<td>( .................... )</td>
								</tr>
							</tbody>
						</table>
					</div>
                </div>
                .
            </div>
        </div>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
        </script>
    </body>
</html>

