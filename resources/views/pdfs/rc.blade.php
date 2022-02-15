<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Tambah Uang ke Kasir</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center border-bottom">
                    <h1>{{ env("NAMA_KLINIK") }}</h1>
                    <h5>
                        {{ env("ALAMAT_KLINIK") }} <br>
                        Telp : {{ env("TELPON_KLINIK") }}  
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
                            <td>{{ App\Models\Classes\Yoga::buatrp( $modal->modal ) }}
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

