<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Dispensing Report</title>
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
	border-collapse : collapse;
}
.bordered td, .bordered th{
	border: 1px solid black;
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
					<h2 class="border-top">Dispensing Rak {{ $rak->id }} mulai tanggal {{ App\Classes\Yoga::updateDatePrep($mulai) }} s/d {{ App\Classes\Yoga::updateDatePrep($akhir) }}</h2>
                </div>
            <div>
				<h2>Merek Terdaftar : </h2>
				<ul>
					@foreach($rak->merek as $merek)
					<li>{{ $merek->merek }}</li>
					@endforeach
				</ul>
                <div class="text-center">
                <div class="text-center">
					<table class="table bordered" id="tableAsuransi">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th>keluar</th>
								<th>masuk</th>
								{{--<th>Keterangan</th>--}}
							</tr>
						</thead>
						<tbody>
							@foreach ($dispensings as $dispensing)
								<tr>
								<td>{!! App\Classes\Yoga::updateDatePrep($dispensing->tanggal) !!}</td>
								<td>{!! $dispensing->keluar !!} {{ $rak->formula->sediaan }}</td>
								<td>{!! $dispensing->masuk !!} {{ $rak->formula->sediaan }}</td>
								  {{--<td>{!! $dispensing->dispensable_type !!} {!! $dispensing->dispensable_id !!}</td>--}}
							</tr>
							@endforeach
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

