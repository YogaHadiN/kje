<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>No Sales Report</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center border-bottom">
                    <h1>{{ ucwords( \Auth::user()->tenant->name ) }}</h1>
                    <h5>
                        {{ ucwords( \Auth::user()->tenant->address ) }} <br>
                        Telp : {{ \Auth::user()->tenant->no_telp }}  
                    </h5>
                    <h2 class="border-top">No Sales</h2>
                </div>
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Nama Petugas</td>
                            <td>:</td>
                            <td>{{ $nosale->staf->nama }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $nosale->created_at->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <td>Jam</td>
                            <td>:</td>
                            <td>{{ $nosale->created_at->format('H:i:s') }}</td>
                        </tr>
						<tr>
                            <td>Uang Masuk</td>
                            <td>:</td>
                            <td>{{ App\Models\Classes\Yoga::buatrp( $nosale->uang_masuk ) }}</td>
                        </tr>
						<tr>
                            <td>Uang Keluar</td>
                            <td>:</td>
                            <td>{{ App\Models\Classes\Yoga::buatrp( $nosale->uang_keluar ) }}</td>
                        </tr>
                        <tr>
                            <td>Tujuan</td>
                            <td>:</td>
                            <td>{{ $nosale->tujuan }}
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div>
                <div class="text-center">
					<div class="table-responsive">
						<table class="table-center">
							<tbody class="text-center">
								<tr class="border-top">
									<td></td>
									<td>Diterima Oleh</td>
								</tr>
								<tr class="tanda-tangan">
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td>{{ $nosale->staf->nama }}</td>
								</tr>
							</tbody>
						</table>
					</div>
                </div>
                .
            </div>
        </div>
        <script type="text/javascript" charset="utf-8">
        </script>
    </body>
</html>

