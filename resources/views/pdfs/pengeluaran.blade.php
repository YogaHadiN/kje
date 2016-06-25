<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pengeluaran</title>
        
        <style type="text/css" media="all">
                        
            *{
                    padding:0.5px;
                    margin:0.5px;
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
                font-size:7;
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
            .tanda-tangan td{
                 padding-top:7px;
            }
                        
                    
        </style>
    </head>
    <body>
        <div class="row" id="content-print">
            <div class="box title-print text-center border-bottom">
                <h2>Laporan Belanja Bukan Obat</h2>
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
                    </tbody>
                </table>
            </div>
            <div class="font-small border-bottom">
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
                        @foreach ($fakturbelanja->pengeluaran as $peng)
                            <tr>
                                <td>{{ $peng->bukanObat->bukan_obat }}</td>
                                <td class="text-right">{{ App\Classes\Yoga::buatrp($peng->harga_satuan) }}</td>
                                <td class="text-right">{{ $peng->jumlah }}</td>
                                <td class="text-right">{{ App\Classes\Yoga::buatrp($peng->harga_satuan * $peng->jumlah) }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td id="totalBiaya" class="text-right" nowrap colspan="3"> {{ App\Classes\Yoga::buatrp($total) }}</td>
                        </tr>    
                    </tfoot>
                </table>
            </div>

               <div class="only-padding">
                   
               </div> 
                <table class="table-center">
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
            </div>
    </body>
</html>

