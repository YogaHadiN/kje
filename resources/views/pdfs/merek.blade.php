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
        border-collapse:collapse;
}
table th, table td{
    border:1px solid black;
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
				<h2 class="text-center border-top"></h2>
        
            </div>
            <div class="box border-bottom">
                    <table class="table table-bordered DT actionAutoWidth" id="tableAsuransi">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Merek</th>
                          <th>Komposisi</th>
                          <th>Rak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mereks as $merek)
                        <tr>
                             <td>{!! $merek->id !!}</td>
                             <td>{!! $merek->merek !!}</td>
                             <td>
                              @foreach($merek->rak->formula->komposisi as $komp)
                                {!! $komp->generik->generik !!} {!!$komp->bobot!!} <br> 
                              @endforeach
                              </td>
                              <td nowrap>
                                  {!! $merek->rak->id !!}
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </body>
</html>
