<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pembayaran Dokter</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />

    </head>
    <body>
        
        <div id="content-print">
                <div class="box title-print text-center border-bottom">
                    <h1>Klinik Jati Elok</h1>
                    <h5>
                        Komplek Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Banten <br>
                        Telp : 021 5977529  
                    </h5>
                <h2 class="text-center border-top">
                    Pembayaran Jasa Dokter 
                </h2>
                </div>
                <div class="box">
                    <table>
                        <tbody>
                            <tr>
                                <td>Tanggal Mulai</td>
                                <td>{{ $bayar->mulai->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Akhir</td>
                                <td>{{ $bayar->akhir->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Nama Dokter</td>
                                <td>{{ $bayar->staf->nama }}</td>
                            </tr>
                            <tr class="border-top">
                                <td>Total</td>
                                <td>
                                    <h2 id="pembayaranDokter">
                                        {{ App\Classes\Yoga::buatrp( $bayar->bayar_dokter ) }}
                                        <!--pembayaran goes here-->
                                    </h2>
                                </td>
                            </tr>
                            <tr class="border-top">
                                <td colspan="2" class="text-right">
                                    {{ App\Classes\Yoga::terbilang( $bayar->bayar_dokter ) }} rupiah
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <div class="border-bottom">
                        Diserahkan pada <span id="tanggal">{{ $bayar->created_at->format('d-m-Y') }}</span> jam <span id="jam"> {{  $bayar->created_at->format('H:i:s')  }}</span>
                    </div>
                    <table class="table-center text-center">
                        <tbody>
                            <tr class="border-top">
                                <td>Diserahkan Oleh</td>
                                <td>Diterima Oleh</td>
                            </tr>
                            <tr class="tanda-tangan">
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>(...... ............. )</td>
                                <td>{{ $bayar->staf->nama }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="small-padding">

                </div>
            </div>
    </body>
</html>
