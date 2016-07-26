<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pendapatan</title>
        
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
        <div class="row" id="content-print">
            <div class="box title-print text-center border-bottom">

				<h1>Klinik Jati Elok</h1>
				<h5>
					Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten <br>
					Telp : 021 5977529  
				</h5>
				<h2 class="text-center border-top">Pendapatan Lain</h2>

            </div>
            <div class="box border-bottom">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td>Sumber Uang</td> 
                            <td>:</td>
							<td>{{ $pendapatan->sumber_uang }}</td> 
                        </tr>  
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
							<td>{{ $pendapatan->created_at->format('d-m-Y') }}</td>
                        </tr>
						<tr>
                            <td>Petugas</td>
                            <td>:</td>
							<td>{{ App\Classes\Yoga::buatrp( $pendapatan->nilai ) }}</td>
                        </tr>
						<tr>
                            <td>Keterangan</td>
                            <td>:</td>
							<td>{{ $pendapatan->keterangan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

               <div class="only-padding">
                   
               </div> 
                <table class="text-center">
                    <tr>
                        <td>Penginput</td>
                        <td>Disahkan Oleh</td>
                    </tr>
                    <tr class="tanda-tangan">
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
					<td class="staf-print">{{ $pendapatan->staf->nama }}</td>
                        <td>( ................. )</td>
                    </tr>
                </table>
               <div class="small-padding">
                   .
               </div> 
            </div>
    </body>
</html>
