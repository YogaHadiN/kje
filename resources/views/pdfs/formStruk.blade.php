            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box title-print text-center">
                    <h1>{{ env("NAMA_KLINIK") }}</h1>
                    <h5>
                        {{ env("ALAMAT_KLINIK") }} <br>
                        Telp : {{ env("TELPON_KLINIK") }}  
                    </h5>
                    <h2 class="text-center border-top border-bottom">Pemeriksaan Dokter</h2>
                </div>
            <div class="box border-bottom">
                <table>
                    <tbody>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td>{{ $periksa->pasien->nama }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{App\Models\Classes\Yoga::updateDatePrep(  $periksa->tanggal  )}}</td>
                        </tr>
                        <tr>
                            <td>Jam Datang</td>
                            <td>:</td>
                            <td>{{ $periksa->jam }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Kuitansi</td>
                            <td>:</td>
                            <td>{{ $periksa->id }}
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div>
                <table class="table table-condensed">
                    <tbody id="transaksi-print">
						@foreach ($periksa->trxa as $trx)
                            @if ($trx['jenis_tarif_id'] <147 || $trx['jenis_tarif_id'] > 150)
                                <tr>
                                    <td>{{ $trx['jenis_tarif'] }}</td>
                                    <td>:</td>
                                    <td class="text-right">{{ $trx['biaya'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
							<td colspan="3" class="strong uang text-right" id="biaya-print">{{ $periksa->struk['total_biaya'] }}</td>
                        </tr>
                        @if($periksa->asuransi_id != 0)
                            <tr>
                                <td nowrap>
                                    Dibayar Asuransi
                                </td>
                                <td>:</td>
                                <td class="uang text-right" id="dibayarAsuransi-print">
									{{ $periksa->struk['dibayar_asuransi'] }}

                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                Pembayaran
                            </td>
                            <td>:</td>
                            <td class="uang text-right" id="pembayaran-print">
                                {{App\Models\Classes\Yoga::buatrp(  $periksa->pembayaran  )}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kembalian
                            </td>
                            <td>:</td>
                            <td class="uang text-right" id="kembalian-print">
                                {{App\Models\Classes\Yoga::buatrp(  $periksa->kembalian  )}}
                            </td>
                        </tr>
                    </tfoot>
                </table>
				<br />
				<br />
                @if($periksa->poli->poli == 'Poli Estetika')
					<h2 class="text-center border-bottom border-top">Detail Harga Obat</h2>
					<table class="table table-bordered table-hover table-condensed">
						<tbody>
							@foreach ($periksa->terapii as $t)
								<tr>
                                    <td colspan="4">{{ $t->merek->rak->kode_rak }} - {{ $t->merek->rak->formula->golongan_obat }}</td>
								</tr>
								<tr class="border-bottom-dash">
									<td nowrap class="text-left" colspan="2">
										@ {{ App\Models\Classes\Yoga::buatrp($t->harga_jual_satuan) }} x {{ $t->jumlah }}
									</td>
									<td nowrap class="text-right" colspan="2">{{ App\Models\Classes\Yoga::buatrp( $t->harga_jual_satuan * $t->jumlah ) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				@endif
                <div class="text-center footer box border-top">
					@include('pdfs.promo')
                </div>
                .
            </div>
        </div>
        <script src="{!! url('js/jquery-2.1.1.js') !!}"></script>
        <script type="text/javascript" charset="utf-8">
            window.print();
        </script>
    
