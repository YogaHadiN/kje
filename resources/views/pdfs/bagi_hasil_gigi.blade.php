<!DOCTYPE html>
<html lang="es" moznomarginboxes mozdisallowselectionprint>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Struk Pembayaran Bagi Hasil Gigi</title>
		<link rel="stylesheet" href="{{ url('css/struk.css') }}" title="" type="" />
    </head>
    <body>
        
        <div id="content-print">
                <div class="box title-print text-center border-bottom">
                    <h1>{{ env("NAMA_KLINIK") }}</h1>
                    <h5>
                        {{ env("ALAMAT_KLINIK") }} <br>
                        Telp : {{ env("TELPON_KLINIK") }}  
                    </h5>
                <h2 class="text-center border-top">
                    Pembayaran Bagi Hasil Gigi
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
                                <td>Menikah</td>
                                <td>
									@if( $bayar->menikah  == 1)
										Menikah
									@else
										Belum Menikah
									@endif
								</td>
                            </tr>
							<tr>
                                <td>Jumlah Anak</td>
                                <td>{{ $bayar->jumlah_anak }}</td>
                            </tr>
                            <tr class="border-top">
                                <td colspan="2">Total</td>
                            </tr>
							<tr>
                                <td colspan="2" class="text-right">
                                    <h2 id="pembayaranDokter">
                                        {{ App\Models\Classes\Yoga::buatrp( $bayar->nilai ) }}
                                        <!--pembayaran goes here-->
                                    </h2>
                                </td>
							</tr>
							<tr class="border-top">
								<td colspan="2" class="text-center"> <h2>Perhitungan Pph</h2> </td>
							</tr>
							<tr class="border-top">
								<td>Gaji Saat Ini</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->nilai ) }}</td>
							</tr>
							<tr>
								<td>Biaya Jabatan</td>
								<td class="text-right">( {{ App\Models\Classes\Yoga::buatrp( $bayar->biaya_jabatan ) }} )</td>
							</tr>
							<tr class="border-top">
								<td>Gaji Netto</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->gaji_netto ) }}</td>
							</tr>
							<tr>
								<td colspan="2">Gaji Netto Setahun</td>
							</tr>
							<tr>
								<td>{{ App\Models\Classes\Yoga::buatrp( $bayar->gaji_netto ) }} x 12 bulan = </td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->gaji_netto * 12 ) }}</td>
							</tr>
							<tr>
								<td>Penghasilan Tidak Kena Pajak</td>
								<td class="text-right">( {{ App\Models\Classes\Yoga::buatrp( $bayar->ptkp ) }} )</td>
							</tr>
							<tr class="border-top">
								<td>Penghasilan Kena Pajak</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp((  $bayar->gaji_netto * 12  ) - $bayar->ptkp ) }}</td>
							</tr>
							<tr>
								@include('pdfs.potongan5persen', ['bayar' => $bayar->penghasilan_kena_pajak])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan5persen)}}</td>
                            </tr>
							<tr>

								@include('pdfs.potongan15persen', ['bayar' => $bayar->penghasilan_kena_pajak])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan15persen)}}</td>
                            </tr>
							<tr>
								@include('pdfs.potongan25persen', ['bayar' => $bayar->penghasilan_kena_pajak])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan25persen) }}</td>
                            </tr>
							<tr>
								@include('pdfs.potongan30persen', ['bayar' => $bayar->penghasilan_kena_pajak])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan30persen) }}</td>
                            </tr>
							<tr class="border-top">
                                <td>Pph 21 Setahun</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->pph21setahun) }}</td>
                            </tr>
							<tr>
                                <td>Pph 21 Bulan Ini</td>
								<td>{{ App\Models\Classes\Yoga::buatrp($bayar->pph21setahun) }} / 12 bulan</td>
                            </tr>
							<tr>
								<td colspan="2" class="text-right"><h2>{{ App\Models\Classes\Yoga::buatrp($bayar->pph21) }}</h2></td>
                            </tr>
							<tr class="border-top">
                                <td colspan="2">Total</td>
                            </tr>
							<tr>
                                <td class="text-right" colspan="2">
                                    <h2 id="pembayaranDokter">
										{{ App\Models\Classes\Yoga::buatrp( $bayar->nilai -  $bayar->pph21 ) }}
                                    </h2>
                                </td>
							</tr>
							<tr>
								<td class="full-width" colspan="2">
									<h3>Pembayaran Bulan Ini</h3>
									<table class="bordered">
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>Pembayaran</th>
												<th>Pph21</th>
											</tr>
										</thead>
										<tbody>
											@foreach( $pembayaran_bulan_ini as $bayar )
												<tr>
													<td>{{ $bayar->created_at->format('d M Y') }}</td>
													<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $bayar->nilai  )}}</td>
													<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $bayar->pph21 ) }}</td>
												</tr>
											@endforeach
										</tbody>
										<tfoot>
											<tr>
												<th></th>
												<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_pembayaran_bulan_ini )}}</th>
												<th class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_pph_bulan_ini ) }}</th>
											</tr>
										</tfoot>
									</table>
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
                                {{--<td>{{ $bayar->staf->nama }}</td>--}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="box">
				<h3>Catatan : Struk Ini BUKAN Merupakan Bukti Potong Pph</h3>
				<h3>Bukti Potong Pph21 akan diberikan pada setiap awal bulan berikutnya</h3>
			</div>
			<div class="small-padding">
				.
			</div>
    </body>
</html>
