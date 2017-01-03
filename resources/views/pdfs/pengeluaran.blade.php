<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pengeluaran</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
        <div class="row" id="content-print">
            <div class="box title-print text-center border-bottom">
                <h2>Laporan Pengeluaran Bukan Obat</h2>
            </div>
            <div class="box border-bottom">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td>Supplier</td> 
                            <td>:</td>
                            <td>{{ $pengeluaran->supplier->nama }}</td> 
                        </tr>  
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
							<td>{{ $pengeluaran->created_at->format('d-m-Y') }}</td>
                        </tr>
						<tr>
                            <td>Nilai</td>
                            <td>:</td>
							<td>{{ App\Classes\Yoga::buatrp( $pengeluaran->nilai ) }}</td>
                        </tr>
						<tr>
                            <td>Keterangan</td>
                            <td>:</td>
							<td>{{ $pengeluaran->keterangan }}</td>
						</tr>
						<tr>
                            <td>Sumber kas</td>
                            <td>:</td>
							<td>{{ $pengeluaran->sumberUang->coa }}</td>
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
					<td class="staf-print">{{ $pengeluaran->staf->nama }}</td>
                        <td>( ................. )</td>
                    </tr>
                </table>
               <div class="small-padding">
                   .
               </div> 
            </div>
    </body>
</html>
