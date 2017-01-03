<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        @if ($fakturbelanja->belanja_id == 1)
            <title>Struk Pembelian Obat</title>
        @elseif ($fakturbelanja->belanja_id == 3)
            <title>Struk Pengeluaran</title>
        @endif
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
        <div class="row" id="content-print">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center border-bottom">
                    <h1>Klinik Jati Elok</h1>
                    <h5>
                        Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten <br>
                        Telp : 021 5977529  
                    </h5>
                </div>
                <div class="box title-print text-center border-bottom">
                @if ($fakturbelanja->belanja_id == 1)
                    <h2>Laporan Penerimaan Obat</h2>
                @elseif ($fakturbelanja->belanja_id == 3)
                    <h2>Laporan Pengeluaran</h2>
                @endif
                </div>
               <div class="box border-bottom">
                   <table class="table table-condensed">
                       <tbody>
                           <tr>
                               <td>Supplier</td> 
                                <td>:</td>
                               <td>{{ $fakturbelanja->supplier->nama }}</td> 
                           </tr>  
                           <tr>
                               <td>Tanggal</td>
                                <td>:</td>
                               <td>{{App\Classes\Yoga::updateDatePrep(  $fakturbelanja->tanggal  )}}</td>
                           </tr>
                           <tr>
                               <td>Nomor Faktur</td>
                                <td>:</td>
                               <td>{{ $fakturbelanja->nomor_faktur }}</td>
                           </tr>
							<tr>
                               <td>Sumber Uang</td>
                                <td>:</td>
								<td>{{ $fakturbelanja->sumberUang->coa }}</td>
                           </tr>
							<tr>
                               <td>Petugas Penginput</td>
                                <td>:</td>
								<td>{{ $fakturbelanja->petugas->nama }}</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
                <div class="font-small border-bottom">
                    <table class="table table-condensed bordered">
                        <tbody id="daftarBelanja">
                            @if ($fakturbelanja->belanja_id == 1)
                                @foreach ($fakturbelanja->pembelian as $pemb)
                                    <tr>
                                        <td colspan="4">{{ $pemb->merek->merek }}</td>
                                    </tr>
									<tr class="border-bottom-dash">
                                        <td nowrap class="text-left" colspan="2">
											@ {{ App\Classes\Yoga::buatrp($pemb->harga_beli) }} x {{ $pemb->jumlah }}
										</td>
                                        <td nowrap class="text-right" colspan="2">{{ App\Classes\Yoga::buatrp( $pemb->harga_beli * $pemb->jumlah ) }}</td>
									</tr>
                                @endforeach
                            @elseif ($fakturbelanja->belanja_id == 4)
                                @foreach ($fakturbelanja->belanjaPeralatan as $pemb)
                                    <tr>
                                        <td	colspan="4">{{ $pemb->peralatan }}</td>
                                    </tr>
									<tr class="border-bottom-dash">
                                        <td nowrap class="text-left" colspan='2'>
											@ {{ App\Classes\Yoga::buatrp($pemb->harga_satuan) }} x {{ $pemb->jumlah }}
										</td>
                                        <td nowrap class="text-right" colspan="2">{{ App\Classes\Yoga::buatrp( $pemb->harga_satuan * $pemb->jumlah ) }}</td>
									</tr>
                                @endforeach
                            @elseif ($fakturbelanja->belanja_id == 3)
                                @foreach ($fakturbelanja->pengeluaran as $pemb)
                                    <tr>
                                        <td colspan='4'>{{ $pemb->bukanObat->nama }}</td>
                                    </tr>
									<tr class="border-bottom-dash">
                                        <td nowrap class="text-left" colspan="2">
											@ {{ App\Classes\Yoga::buatrp($pemb->harga_satuan) }} x {{ $pemb->jumlah }}
										</td>
                                        <td nowrap class="text-right" colspan="2">{{ App\Classes\Yoga::buatrp( $pemb->harga_satuan * $pemb->jumlah ) }}</td>
									</tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot class="big">
                            <tr>
								<td id="totalBiaya" class="strong uang text-right" nowrap colspan="4">
									{{ App\Classes\Yoga::buatrp( $total ) }}
								</td>
                            </tr>    
                        </tfoot>
                    </table>
                </div>
                </div>
               <div class="only-padding">
                   
               </div> 
                <table class="table-center text-center">
                    <tr>
                        <td>Penginput</td>
                        <td>Disahkan Oleh</td>
                    </tr>
                    <tr class="tanda-tangan">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="staf-print"></td>
                        <td>( ................. )</td>
                    </tr>
                </table>
               <div class="small-padding">
                   

               </div> 
               .
            </div>
    </body>
</html>
