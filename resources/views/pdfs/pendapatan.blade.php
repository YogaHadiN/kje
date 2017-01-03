<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pendapatan</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

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
