<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Tambah Uang ke Kasir</title>
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
                    <h3 class="border-top">Tambah Uang Ke Kasir</h3>
                </div>
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Nama Petugas</td>
                            <td>:</td>
                            <td>{{ $modal->staf->nama }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $modal->created_at->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Sumber Uang</td>
                            <td>:</td>
                            <td>{{ $modal->coa->coa }}</td>
                        </tr>
                        <tr class="big">
                            <td>Jumlah</td>
                            <td>:</td>
                            <td>{{ App\Classes\Yoga::buatrp( $modal->modal ) }}
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div>
                    <div class="text-center">
                    <table class="table-center">
                        <tbody class="text-center">
                            <tr class="border-top">
                                <td>Nama Petugas</td>
                                <td>Saksi</td>
                            </tr>
                            <tr class="tanda-tangan">
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ $modal->staf->nama }}</td>
                                <td>( .................... )</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                .
            </div>
        </div>
        <script type="text/javascript" charset="utf-8">
        </script>
    </body>
</html>

