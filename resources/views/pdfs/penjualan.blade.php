<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
            <title>Penjualan Obat</title>
        
        
        <style type="text/css" media="all">
        
*{
        padding:2px;
        margin:2px;
}
.font-small {
    font-size:7;
}
.tanda-tangan td{
    padding:23px
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
    font-size:9;
}
tfoot {
     padding-top:4px;
}
.big{
    font-size:7px;
        font-weight:bold;
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
                                font-size:15;
                                font-weight:bold;
                            }
        
        </style>
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
                    <h2 class="text-center border-top">
                        @if ($nota_jual->tipe_jual_id == 1)
                            Penjualan
                        @else
                            Pendapatan Lain
                        @endif
                    </h2>
                </div>
               <div class="box border-bottom">
                   <table class="table table-condensed">
                       <tbody>
                           <tr>
                               <td>Nomor Faktur</td>
                                <td>:</td>
                               <td>{{ $nota_jual->id }}</td>
                           </tr>
                           <tr>
                               <td>Nama Kasir</td>
                                <td>:</td>
                                <td>{{ $nota_jual->staf->nama }}</td>
                           </tr>
                            <tr>
                               <td>Tanggal</td>
                                <td>:</td>
                                <td>{{ $nota_jual->created_at->format('d-m-Y')}}</td>
                           </tr>
                            <tr>
                               <td>Jam</td>
                                <td>:</td>
                                <td>{{ $nota_jual->created_at->format('H:i:s')}}</td>
                           </tr>
                       </tbody>
                   </table>
               </div>
                <div class="font-small border-bottom">
                    @if ($nota_jual->tipe_jual_id == 1)
                        <table class="table table-condensed bordered">
                            <thead>
                                <tr>
                                    <th>Merek</th>
                                    <th>Rp</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody id="daftarBelanja">
                                @foreach ($nota_jual->penjualan as $pemb)
                                    <tr>
                                        <td>{{ $pemb->merek->merek }}</td>
                                        <td nowrap class="text-right">{{ App\Classes\Yoga::buatrp($pemb->harga_jual) }}</td>
                                        <td nowrap class="text-right">{{ $pemb->jumlah }}</td>
                                        <td nowrap class="text-right">{{ App\Classes\Yoga::buatrp( $pemb->harga_jual * $pemb->jumlah ) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="big">
                                <tr>
                                    <td>Total</td>
                                    <td id="totalBiaya" class="text-right" nowrap colspan="3">{{ App\Classes\Yoga::buatrp( $total ) }}</td>
                                </tr>    
                            </tfoot>
                        </table>
                    @elseif($nota_jual->tipe_jual_id == 2)
                        <table class="table table-condensed bordered">
                            <thead>
                                <tr>
                                    <th>Pendapatan Lain</th>
                                    <th>Rp</th>
                                    <th>Ket</th>
                                </tr>
                            </thead>
                            <tbody id="daftarBelanja" class="font-small">
                                @foreach ($nota_jual->pendapatan as $pemb)
                                    <tr>
                                        <td>{{ $pemb->pendapatan }}</td>
                                        <td class="text-right">{{ App\Classes\Yoga::buatrp( $pemb->biaya ) }}</td>
                                        <td>{{ $pemb->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="big">
                                <tr>
                                    <td>Total</td>
                                    <td id="totalBiaya" colspan="2" class="text-right">{{ App\Classes\Yoga::buatrp( $total ) }}</td>
                                </tr>    
                            </tfoot>
                        </table>
                    @endif
                </div>
                </div>
               <div class="only-padding">
                   
               </div> 
               @if ($nota_jual->tipe_jual_id == 1)
                    <div class="text-center footer box">
                        <h3>
                            Semoga Lekas Sembuh
                        </h3>
                    </div>
               @elseif ($nota_jual->tipe_jual_id == 2)
                <div class="text-center">
                    <table class="table-center">
                        <tbody class="text-center">
                            <tr class="border-top">
                                <td>Diserahkan Oleh</td>
                                <td>Diterima Oleh</td>
                            </tr>
                            <tr class="tanda-tangan">
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>( .................... )</td>
                                <td>{{ $nota_jual->staf->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="text-center">Untuk Diserahkan Kepada Yang Mengantar Uang</p>
               @endif
                
               <div class="small-padding">
                   

               </div> 
               .
            </div>
    </body>
</html>

