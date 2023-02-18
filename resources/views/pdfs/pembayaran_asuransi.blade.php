<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Pembayaran Asuransi {{ $pembayaran->asuransi->nama }}</title>
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
                <h2 class="text-center border-top">Pembayaran {{ $pembayaran->asuransi->nama }}</h2>
            </div >
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Periode</td>
                            <td>:</td>
                            <td>{{App\Models\Classes\Yoga::updateDatePrep(  $pembayaran->mulai  )}}</td>
                        </tr>
                        <tr>
                            <td>Akhir</td>
                            <td>:</td>
                            <td>{{App\Models\Classes\Yoga::updateDatePrep(  $pembayaran->akhir  )}}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Diserahkan</td>
                            <td>:</td>
                            <td>{{App\Models\Classes\Yoga::updateDatePrep(  $pembayaran->tanggal_dibayar  )}}</td>
                        </tr>
                        <tr>
                            <td>Petugas</td>
                            <td>:</td>
                            <td>{{ $pembayaran->staf->nama }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="big text-right">{{ App\Models\Classes\Yoga::buatrp($pembayaran->pembayaran) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">{{ App\Models\Classes\Yoga::terbilang($pembayaran->pembayaran) }} rupiah</td>
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

