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
    font-size:7;
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
                    </tbody>
                </table>
            </div>
            <div>
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
                        <tr class="border-top big">
                            <td class="">Total :</td>
                            <td colspan="3" class="text-right">{{ App\Classes\Yoga::buatrp($total_nilai) }}</td>
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

