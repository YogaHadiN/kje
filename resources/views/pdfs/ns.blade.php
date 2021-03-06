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
                    <h1>Klinik Jati Elok</h1>
                    <h5>
                        Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten <br>
                        Telp : 021 5977529  
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
                            <td>Tujuan</td>
                            <td>:</td>
                            <td>{{ $nosale->tujuan }}
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div>
                <div class="text-center">
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
                .
            </div>
        </div>
        <script type="text/javascript" charset="utf-8">
        </script>
    </body>
</html>

