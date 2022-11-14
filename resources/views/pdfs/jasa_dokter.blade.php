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
                    <h1>{{ ucwords( \Auth::user()->tenant->name ) }}</h1>
                    <h5>
                        {{ ucwords( \Auth::user()->tenant->address ) }} <br>
                        Telp : {{ \Auth::user()->tenant->no_telp }}  
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
							<tr>
                                <td>Menikah</td>
                                <td>
									@if( $bayar->staf->menikah  == 1)
										Menikah
									@else
										Belum Menikah
									@endif
								</td>
                            </tr>
							<tr>
                                <td>Jumlah Anak</td>
                                <td>{{ $bayar->staf->jumlah_anak }}</td>
                            </tr>
                            <tr class="border-top">
                                <td>Total</td>
                                <td class="text-right">
                                    <h2 id="pembayaranDokter">
                                        {{ App\Models\Classes\Yoga::buatrp( $bayar->gaji_bruto ) }}
                                        <!--pembayaran goes here-->
                                    </h2>
                                </td>
                            </tr>
							<tr>
								<td class="text-center border-top" colspan="2"><h3>Perhitungan Pph21</h2></td>
							</tr>
							
							<tr>
                                <td>Penghasilan Bruto Setahun</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->gaji_bruto)}}</td>
                            </tr>
							<tr>
                                <td>Penghasilan Netto Setahun</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->penghasilan_bruto_setahun / 2)}}</td>
                            </tr>
							<tr>
                                <td>PTKP Setahun</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->ptkp_setahun)}}</td>
                            </tr>
							<tr>
                                <td>Penghasiln Kena Pajak</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp(( $bayar->penghasilan_bruto_setahun /2 ) - $bayar->ptkp_setahun)}}</td>
                            </tr>
							<tr>
							@include('pdfs.potongan5persen' , ['bayar' => $bayar->penghasilan_kena_pajak_setahun ])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan5persen_setahun)}}</td>
                            </tr>
							<tr>
								@include('pdfs.potongan15persen', ['bayar' => $bayar->penghasilan_kena_pajak_setahun ])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan15persen_setahun)}}</td>
                            </tr>
							<tr>
								@include('pdfs.potongan25persen', ['bayar' => $bayar->penghasilan_kena_pajak_setahun ])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan25persen_setahun) }}</td>
                            </tr>
							<tr>
								@include('pdfs.potongan30persen', ['bayar' => $bayar->penghasilan_kena_pajak_setahun ])
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp($bayar->potongan30persen_setahun) }}</td>
                            </tr>
							<tr>
                                <td>Pph21 setahun ( simulasi )</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp(
									$bayar->potongan5persen_setahun +
									$bayar->potongan15persen_setahun +
									$bayar->potongan25persen_setahun +
									$bayar->potongan30persen_setahun
								)  }}
								</td>
                            </tr>
							<tr>
                                <td>Potongan Pph21 sudah dibayar</td>
								<td class="text-right">{{ App\Models\Classes\Yoga::buatrp( $total_pph_sudah_dibayar ) }}</td>
                            </tr>
							<tr>
                                <td>Pph 21 Yang Dipotong Saat Ini</td>
                                <td class="text-right">
									<h2 id="pembayaranDokter">
										<!--pembayaran goes here-->
                                        {{ App\Models\Classes\Yoga::buatrp( $bayar->pph21 ) }}
									</h2>
								</td>
                            </tr>
							<tr class="border-top">
                                <td>Total</td>
                                <td class="text-right">
                                    <h2 id="pembayaranDokter">
										{{ App\Models\Classes\Yoga::buatrp( $bayar->bayar_dokter -  $bayar->pph21 ) }}
                                        <!--pembayaran goes here-->
                                    </h2>
                                </td>
                            </tr>
                            <tr class="border-top">
                                <td colspan="2" class="text-right">
									{{-- {{ App\Models\Classes\Yoga::terbilang( $bayar->bayar_dokter - $bayar->pph21 ) }} rupiah --}}
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
													<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $bayar->bayar_dokter  )}}</td>
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
				{{--<div class="box">--}}
					{{--<h3>Perhitungan Pph yang sudah dibayarkan sebelumnya</h3>--}}
                    {{--<table class="bordered">--}}
						{{--<thead>--}}
							{{--<tr>--}}
								{{--<th>Bulan</th>--}}
								{{--<th>Penghasilan Bruto</th>--}}
								{{--<th>PTKP</th>--}}
								{{--<th>Pph21</th>--}}
							{{--</tr>--}}
						{{--</thead>--}}
                        {{--<tbody>--}}
							{{--@if(count(  json_decode( $bayar->perhitungan_pph, true )  ) > 0)--}}
								{{--@foreach(json_decode(  $bayar->perhitungan_pph , true ) as $k=> $r) --}}
									{{--<tr>--}}
										{{--<td>{{ $k }}</td>--}}
										{{--<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $r['penghasilan_bruto_bulan_ini']  )}}</td>--}}
										{{--<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $r['ptkpBulanIni']  )}}</td>--}}
										{{--<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $r['pph']  )}}</td>--}}
									{{--</tr>--}}
								{{--@endforeach--}}
							{{--@endif--}}
						{{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
				@if( $bayar->ada_penghasilan_lain == 0 && $bayar->staf->jenis_kelamin == 1 )
				<div>
					<p>Saya yang bertanda tangan di bawah ini menyatakan bahwa saya Dokter {{ ucwords( \Auth::user()->tenant->name ) }}, {{ $bayar->staf->nama }}. Menyatakan bahwa benar pada bulan ini sampai dengan hari ini tanggal {{ $bayar->created_at->format('d M Y') }} saya tidak menerima penghasilan lain selain dari pekerjaan saya sebagai dokter di {{ ucwords( \Auth::user()->tenant->name ) }}, saya hanya mempunyai hubungan dengan satu pemberi kerja, dan saya tidak punya potongan Pph di tempat lain selain di {{ ucwords( \Auth::user()->tenant->name ) }}</p>
				</div>
				@endif
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
