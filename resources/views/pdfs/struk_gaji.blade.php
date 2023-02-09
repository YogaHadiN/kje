<!DOCTYPE html>
<html lang="es">
z   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Gaji</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />
    </head>
    <body>
    <div id="content-print">
            <div class="box title-print text-center">
                    <h1>{{ ucwords( \Auth::user()->tenant->name ) }}</h1>
                    <h5>
                        {{ ucwords( \Auth::user()->tenant->address ) }} <br>
                        Telp : {{ \Auth::user()->tenant->no_telp }}  
                    </h5>
            </div>
            <h2 class="text-center border-top border-bottom">Slip Gaji</h2>
            <div>
                <table>
                    <tbody>
                        <tr>
                            <td nowrap>Tanggal Dibayar</td>
                            <td>{{ $bayar->tanggal_dibayar->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td nowrap>Nama Staf Penerima</td>
                            <td>{{ $bayar->staf->nama }}</td>
                        </tr>
                        <tr>
                            <td nowrap>Status Pernikahan</td>
                            <td>
                                @if( $bayar->pph21s->menikah == 1 )
                                    Menikah
                                @else
                                    Belum Menikah
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td nowrap>Jumlah Anak</td>
                            <td>{{ $bayar->pph21s->jumlah_anak }}</td>
                        </tr>
                        @if ($bayar->staf->titel != 'dr')
                            <tr>
                                <td nowrap>Gaji Pokok</td>
                                <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->gaji_pokok) }}</td>
                            </tr>
                            <tr>
                                <td nowrap>Bonus</td>
                                <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->bonus) }}</td>
                            </tr>
                        @endif
                        <tr class="border-top">
                            <td nowrap>Gaji Kotor Saat Ini</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($total_gaji) }}</td>
                        </tr>
                        @if(isset( $bayar->pph21s->pph21 ))
                        <tr class="border-top border-bottom">
                            <td class="text-center" colspan="2">
                                <h2>Gaji Bruto Bulan Ini</h2>
                            </td>
                        </tr>
                        @foreach( json_decode($bayar->pph21s->ikhtisar_gaji_bruto, true) as $gaji )
                        <tr>
                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d',  $gaji['tanggal_dibayar'] )->format('d M') }}</td>
                            <td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $gaji['gaji_bruto']  )}}</td>
                        </tr>
                        @endforeach
                        <tr class="border-top">
                            <td nowrap>Total Gaji Bulan Ini</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->total_bruto) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="text-center" colspan="2">
                                <h2>Perhitungan Pph</h2>
                            </td>
                        </tr>
                        <tr class="border-top">
                            <td nowrap>Total Gaji Bulan Ini</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->total_bruto) }}</td>
                        </tr>
                        <tr>
                            <td nowrap>Biaya Jabatan</td>
                            <td class="text-right">
                                ( {{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->biaya_jabatan) }} )
                            </td>
                        </tr>
                        <tr>
                            <td nowrap>Gaji Netto</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->gaji_netto) }}</td>
                        </tr>
                        <tr>
                            <td nowrap>Gaji Netto Setahun  <strong>{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->gaji_netto) }} x 12 bulan </strong></td>
                            <td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->gaji_netto * 12) }}</td>
                        </tr>
                        <tr>
                            <td nowrap>
                                Penghasilan Tidak Kena Pajak 
                                @if( $bayar->menikah || $bayar->jumlah_anak)
                                (
                                @endif
                                @if( $bayar->menikah )
                                    Menikah
                                @endif
                                @if( $bayar->menikah && $bayar->jumlah_anak)
                                dengan 
                                @endif
                                @if( $bayar->jumlah_anak )
                                    {{ $bayar->jumlah_anak }}
                                    anak
                                @endif
                                @if( $bayar->menikah || $bayar->jumlah_anak)
                                )
                                @endif
                            </td>
                            <td class="text-right">( {{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->ptkp_setahun) }} )</td>
                        </tr>
                        <tr class="border-top">
                            <td nowrap>Penghasilan Kena Pajak</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->penghasilan_kena_pajak_setahun)}}</td>
                        </tr>
                        <tr>
                            @include('pdfs.potongan5persen', ['bayar' => $bayar->pph21s->penghasilan_kena_pajak_setahun])
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->potongan5persen_setahun ) }}</td>
                        </tr>
                        <tr>
                            @include('pdfs.potongan15persen', ['bayar' => $bayar->pph21s->penghasilan_kena_pajak_setahun])
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->potongan15persen_setahun ) }}</td>
                        </tr>
                        <tr>
                            @include('pdfs.potongan25persen', ['bayar' => $bayar->pph21s->penghasilan_kena_pajak_setahun])
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->potongan25persen_setahun ) }}</td>
                        </tr>
                        <tr>
                            @include('pdfs.potongan30persen', ['bayar' => $bayar->pph21s->penghasilan_kena_pajak_setahun])
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->potongan30persen_setahun ) }}</td>
                        </tr>
                        <tr>
                            @include('pdfs.potongan35persen', ['bayar' => $bayar->pph21s->penghasilan_kena_pajak_setahun])
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->potongan35persen_setahun ) }}</td>
                        </tr>
                        @if(empty( trim(  $bayar->staf->npwp  ) ))
                            <tr class="border-top">
                                <td colspan="2" class="text-right">
                                    {{ App\Models\Classes\Yoga::buatrp(
                                        $bayar->pph21s->potongan5persen_setahun +
                                        $bayar->pph21s->potongan15persen_setahun +
                                        $bayar->pph21s->potongan25persen_setahun +
                                        $bayar->pph21s->potongan30persen_setahun
                                    ) }}
                                </td>
                            </tr>
                            <tr class="border-top">
                                <td colspan="2"><strong>Karena Tidak punya NPWP,maka staf ini dibebani 1,2 kali pajak normal</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                    1,2 x {{ App\Models\Classes\Yoga::buatrp(
                                        $bayar->pph21s->potongan5persen_setahun +
                                        $bayar->pph21s->potongan15persen_setahun +
                                        $bayar->pph21s->potongan25persen_setahun +
                                        $bayar->pph21s->potongan30persen_setahun
                                    ) }} 
                                    = {{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->pph21_setahun) }}
                                </td>
                            </tr>
                        @endif
                        <tr class="border-top">
                            <td nowrap>Pph21 setahun (simulasi)</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->pph21_setahun) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td nowrap>Pph21 sebulan (simulasi) {{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->pph21_setahun)  }} / 12 = </td>
                            <td class="text-right"> {{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->pph21_setahun / 12)  }}</td>
                        </tr>
                        <tr>
                            <td> pph21 Sudah Dibayarkan Sebelumnya </td>
                            <td class="text-right">({{ App\Models\Classes\Yoga::buatrp($pph21_sudah_dibayar_sebelumnya) }})</td>
                        </tr>
                        <tr class="border-top">
                            <td nowrap>Pph21 dibayarkan sekarang</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->pph21) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td colspan="2">Gaji Yang Dibayarkan Sekarang = {{ App\Models\Classes\Yoga::buatrp( $bayar->pph21s->gaji_bruto ) }} ({{ App\Models\Classes\Yoga::buatrp($bayar->pph21s->pph21) }}) </td>
                        </tr>
                        @endif
                        <tr class="border-top">
                            <td colspan="2">Total</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <h2 id="pembayaranDokter">
                                    {{ App\Models\Classes\Yoga::buatrp( $total_gaji  - $bayar->pph21s->pph21) }}
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Terbilang</td>
                        </tr>
                        <tr>
                            <td colspan="2">{{ App\Models\Classes\Yoga::terbilang( $total_gaji  - $bayar->pph21s->pph21) }} rupiah</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                Diserahkan pada <span id="tanggal">{{ $bayar->created_at->format('d-m-Y') }}</span> jam <span id="jam"> {{  $bayar->created_at->format('H:i:s')  }}</span>
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
            @if ( count(  json_decode($bayar->pph21s->ikhtisar_gaji_bruto,true)   ) )
            <div>
                <div class="border-top text-center">
                    <h2>Ikhtisar Gaji Bulan Ini</h2>
                </div>
                <table class="bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Gaji Bruto</th>
                            <th>Pph21</th>
                            <th>Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( json_decode($bayar->pph21s->ikhtisar_gaji_bruto,true) as $g )
                        <tr>
                            <td>{{ $g['tanggal_dibayar'] }}</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $g['gaji_bruto'] ) }}</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $g['pph21'] ) }}</td>
                            <td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $g['gaji_bruto'] - $g['pph21'] ) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>TOTAL</th>
                            <th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->pph21s->total_bruto ) }}</th>
                            <th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->pph21s->total_pph21 ) }}</th>
                            <th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->pph21s->total_bayar ) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endif
            <div class="small-padding">
                .
            </div>
        </div>
    </body>
</html>

