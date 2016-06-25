<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pembayaran Dokter</title>
        <style type="text/css" media="all">
        
*{
        padding:0.5px;
        margin:0.5px;
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
    font-size:6;
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
            
        
        </style>
    </head>
    <body>
        
        <div id="content-print">
                <div class="box title-print text-center border-bottom">
                    <h1>Klinik Jati Elok</h1>
                    <h5>
                        Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten <br>
                        Telp : 021 5977529  
                    </h5>
                </div>
                <h3 class="text-center">Slip Gaji</h3>
                <hr>
                <div class="box">
                    <table>
                        <tbody>
                            <tr>
                                <td>Tanggal Mulai</td>
                                <td>{{ $bayar->mulai->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td>{{ $bayar->akhir->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Nama Staf Penerima</td>
                                <td>{{ $bayar->staf->nama }}</td>
                            </tr>
                            <tr>
                                <td>Gaji Pokok</td>
                                <td>{{ App\Classes\Yoga::buatrp($bayar->gaji_pokok) }}</td>
                            </tr>
                            <tr>
                                <td>Bonus</td>
                                <td>{{ App\Classes\Yoga::buatrp($bayar->bonus) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td>Total</td>
                                <td>
                                    <h2 id="pembayaranDokter">
                                        {{ App\Classes\Yoga::buatrp( $bayar->gaji_pokok + $bayar->bonus ) }}
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td>Terbilang</td>
                                <td>{{ App\Classes\Yoga::terbilang($bayar->gaji_pokok + $bayar->bonus) }} rupiah</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    Diserahkan pada <span id="tanggal">{{ $bayar->created_at->format('d-m-Y') }}</span> jam <span id="jam"> {{  $bayar->created_at->format('H:i:s')  }}</span>
                    <table class="table-center text-center">
                        <tbody>
                            <tr class="border-top">
                                <td>Diserahkan Oleh</td>
                                <td>Diterima Oleh</td>
                            </tr>
                            <tr class="tanda-tangan">
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>(...... ............. )</td>
                                <td>{{ $bayar->staf->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="small-padding">
                    .
                </div>
            </div>
    </body>
</html>

