<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Pembayaran Asuransi {{ $pembayaran->asuransi->nama }}</title>
        <style type="text/css" media="all">
        
*{
        padding:2px;
        margin:2px;
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
                <h2 class="text-center border-top">Pembayaran {{ $pembayaran->asuransi->nama }}</h2>
            </div >
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Periode</td>
                            <td>:</td>
                            <td>{{App\Classes\Yoga::updateDatePrep(  $pembayaran->mulai  )}}</td>
                        </tr>
                        <tr>
                            <td>Akhir</td>
                            <td>:</td>
                            <td>{{App\Classes\Yoga::updateDatePrep(  $pembayaran->akhir  )}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Diserahkan</td>
                            <td>:</td>
                            <td>{{App\Classes\Yoga::updateDatePrep(  $pembayaran->tanggal_dibayar  )}}</td>
                        </tr>
                        <tr>
                            <td>Petugas</td>
                            <td>:</td>
                            <td>{{ $pembayaran->staf->nama }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="big text-right">{{ App\Classes\Yoga::buatrp($pembayaran->pembayaran) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">{{ App\Classes\Yoga::terbilang($pembayaran->pembayaran) }} rupiah</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <h3>Untuk Disimpan</h3>
            </div>
            <div>

                .
            </div>
        </div>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
        </script>
    </body>
</html>

