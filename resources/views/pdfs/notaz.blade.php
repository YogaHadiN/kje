<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Nota Z</title>
        <style type="text/css" media="all">
                *{
                        padding:2px;
                        margin:2px;
                }
                table {
                    border-collapse:collapse;
                }
                table.bordered td{
                    border: 1px solid #ddd;
                }
                .tanda-tangan td{
                    padding:23px
                }
                .font-small{
                    font-size:5;
                }
                table{
                    width:100%;
                }

                h1{
                    font-weight:normal;
                }
                h5{
                    font-weight:normal;
                }

                body{
                    font-family: Trebuchet, Arial, sans-serif;
                    font-size:6;
                }
                tfoot {
                     padding-top:4px;
                }
                .text-right {
                    text-align:right;
                }

                .text-center {
                    text-align:center;
                }
                hr {
                    border: none;
                    height: 0.01mm;
                    /* Set the hr color */
                    color: #333; /* old IE */
                    background-color: #333; /* Modern Browsers */
                }
                            .footer{
                                padding:5px;
                            }
                            .border-bottom{
                                border-bottom: 0.3px solid black;
                            }
                            .border-top{
                                border-top: 0.3px solid black;
                            }
                            .small-padding{
                                 padding:12px;
                            }
            
                            .big{
                                font-size:10;
                                font-weight:bold;
                            }
        
        </style>
    </head>
    <body>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center border-bottom">
                    <h1>Klinik Jati Elok</h1>
                    <h5>
                        Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten <br>
                        Telp : 021 5977529  
                    </h5>
                    <h3 class="border-top">Nota Z</h3>
                </div>
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $notaz->created_at->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Jam</td>
                            <td>:</td>
                            <td>{{ $notaz->created_at->format('H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td>Uang di Kasir</td>
                            <td>:</td>
                            <td>{{ App\Classes\Yoga::buatrp( $notaz->uang_di_kasir ) }}</td>
                        </tr>
                        <tr>
                            <td>Uang Masuk</td>
                            <td>:</td>
                            <td>{{ App\Classes\Yoga::buatrp( $notaz->uang_masuk ) }}</td>
                        </tr>
                        <tr>
                            <td>Uang Keluar</td>
                            <td>:</td>
                            <td>{{ App\Classes\Yoga::buatrp( $notaz->uang_keluar ) }}</td>
                        </tr>
						<tr>
                            <td>Modal Awal</td>
                            <td>:</td>
                            <td>{{ App\Classes\Yoga::buatrp( $notaz->modal_awal ) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <h4>Uang Masuk</h4>
                <table class="table table-condensed bordered">
                    <thead>
                        <tr>
                            <td colspan="2">Jenis Tarif</td>
                            <td>Jumlah</td>
                            <td>Biaya</td>
                        </tr>
                    </thead>
                    <tbody id="transaksi-print" class="font-small">
                        @foreach ($notaz->checkoutDetail as $trx)
                            <tr>
                                <td>{{ $trx->coa->coa }}</td>
                                <td>:</td>
                                <td class="text-right">{{ $trx->jumlah }}</td>
                                <td class="text-right">{{ App\Classes\Yoga::buatrp( $trx->nilai ) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
					<tfoot>
						<tr>
							<td colspan="2"><h3>Total Pemasukan</h3></td>
							<td colspan="2" class="text-right"><h3>{{ App\Classes\Yoga::buatrp($total_pemasukan) }}</h3></td>
						</tr>
					</tfoot>
                </table>
                <h4>Uang Keluar</h4>
                <table class="table table-condensed bordered">
                    <thead>
                        <tr>
                            <td>Penerima</td>
                            <td>Biaya</td>
                        </tr>
                    </thead>
                    <tbody id="transaksi-print" class="font-small">
                      @foreach($pengeluarans as $plr)
                          <tr>
                              <td>
									  @if ($plr->jurnalable_type == 'App\FakturBelanja')
										  @if (isset($plr->jurnalable->supplier['nama']))
										  {{ $plr->jurnalable->supplier['nama'] }}
										 @endif
									  @elseif ($plr->jurnalable_type == 'App\BayarDokter')
										  {{ $plr->jurnalable->staf->nama }}
									  @elseif ($plr->jurnalable_type == 'App\Pengeluaran')
										  {{ $plr->jurnalable->supplier['nama'] }}
									  @elseif ($plr->jurnalable_type == 'App\BayarGaji')
										  {{ $plr->jurnalable->staf->nama }}
									  @endif
                                      
                                  </td>
                              <td class="text-right">{{App\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
                          </tr>
                      @endforeach
                    </tbody>
					<tfoot>
						<tr>
							<td><h3>Total Pengeluaran</h3></td>
							<td class="text-right"><h3>{{ App\Classes\Yoga::buatrp($total_pengeluaran) }}</h3></td>
						</tr>
					</tfoot>
                </table>

                <h4>Modal Yang Masuk</h4>
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
							  <td>{{ $plr->coa->coa }}</td>
							  <td>{{ $plt->keterangan }}</td>
                              <td class="text-right">{{App\Classes\Yoga::buatrp(  $plr->nilai  )}}</td>
                          </tr>
                      @endforeach
                    </tbody>
					<tfoot>
						<tr>
							<td><h3>Total Modal</h3></td>
							<td class="text-right"><h3>{{ App\Classes\Yoga::buatrp($total_modal) }}</h3></td>
						</tr>
					</tfoot>
                </table>
                <div class="text-center">
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
                .
            </div>
        </div>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
        </script>
    </body>
</html>

