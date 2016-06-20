<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk {{ $periksa->id }} | {{ $periksa->pasien->nama }}</title>
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
    font-size:3;
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
            </div >
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td>{{ $periksa->pasien->nama }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{App\Classes\Yoga::updateDatePrep(  $periksa->tanggal  )}}</td>
                        </tr>
                        <tr>
                            <td>Jam Datang</td>
                            <td>:</td>
                            <td>{{ $periksa->jam }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Kuitansi</td>
                            <td>:</td>
                            <td>{{ $periksa->id }}
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table table-condensed">
                    <tbody id="transaksi-print">
                        @foreach ($trxa as $trx)
                            @if ($trx['jenis_tarif_id'] <147 || $trx['jenis_tarif_id'] > 150)
                                <tr>
                                    <td>{{ $trx['jenis_tarif'] }}</td>
                                    <td>:</td>
                                    <td class="text-right">{{ $trx['biaya'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-top big">
                            <td class="">Total</td>
                            <td>:</td>
                            <td class="uang text-right" id="biaya-print">{{ $total_biaya }}</td>
                        </tr>
                        @if($periksa->asuransi_id != 0)
                            <tr>
                                <td nowrap>
                                    Dibayar Asuransi
                                </td>
                                <td>:</td>
                                <td class="uang text-right" id="dibayarAsuransi-print">
                                    {{ $dibayar_asuransi }}

                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                Pembayaran
                            </td>
                            <td>:</td>
                            <td class="uang text-right" id="pembayaran-print">
                                {{App\Classes\Yoga::buatrp(  $periksa->pembayaran  )}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kembalian
                            </td>
                            <td>:</td>
                            <td class="uang text-right" id="kembalian-print">
                                {{App\Classes\Yoga::buatrp(  $periksa->kembalian  )}}
                            </td>
                        </tr>

                    </tfoot>
                </table>
                <div class="text-center footer box border-top">
                    Semoga Lekas Sembuh
                </div>
                .
            </div>
        </div>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
            window.print();
        </script>
    </body>
</html>
