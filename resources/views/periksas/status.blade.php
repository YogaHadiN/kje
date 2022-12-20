<div class="table-responsive">
	<table class="table table-bordered table-hover" id="tableAsuransi">
		  <thead>
			<tr>
				<th>Tanggal</th>
				<th>Status</th>
				<th>Terapi</th>
			</tr>
		</thead>
		<tbody>
			 <tr>
					<td rowspan="2">
						{!! $periksa->tanggal !!} <br><br>
						<strong>Pemeriksa :</strong><br> 
						{!! $periksa->staf->nama !!} <br><br>
						<strong>Pembayaran</strong> <br>
						{!! $periksa->asuransi->nama !!} <br><br>
						<strong>Nomor Asuransi</strong> <br>
						{!! $periksa->nomor_asuransi !!} <br><br>
						<strong>Jam Datang</strong> <br>
						{!! $periksa->jam !!} <br><br>
						<strong>Jam Periksa</strong> <br>
						{!! $periksa->created_at !!} <br><br>
						<strong>Jam Terima Obat</strong> <br>
						{!! $periksa->jam_terima_obat !!} <br><br>
						<strong>Periksa id</strong> <br>
						{!! $periksa->id !!} <br></br>
						<strong>Invoice Id</strong> <br>
						<a href="{{ url('invoices/' . $periksa->invoice_id   ) }}" target="_blank">
							{!! $periksa->invoice_id !!}
						</a>
					</td>
					<td>
						<strong>Anamnesa :</strong> <br>
						{!! $periksa->anamnesa !!} <br>
						<strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br>
						{!! $periksa->pemeriksaan_fisik !!} <br>
						{!! $periksa->pemeriksaan_penunjang !!}<br>
						@if( !empty($periksa->sistolik) || !empty($periksa->sistolik))
							<strong>Tekanan Darah</strong> <br>
							{!! $periksa->sistolik !!}/{!! $periksa->diastolik !!} mmHg  <br>
						@endif
						<strong>Diagnosa :</strong> <br>
						{!! $periksa->diagnosa->diagnosa !!} - {!! $periksa->diagnosa->icd10_id !!} ({!! $periksa->diagnosa->icd10->diagnosaICD !!})
                        @if( !empty( trim( $periksa->keterangan_diagnosa ) ) )
                            <br>
                            {!! $periksa->keterangan_diagnosa !!} 
                        @endif

                        @if(isset( $periksa->rujukan ))
                            <br> <br>
                            <strong>Diagnosis Merujuk</strong><br>
                            {!! $periksa->rujukan->diagnosa->diagnosa !!} ({!! $periksa->rujukan->diagnosa->icd10_id!!} - 
                            {!! $periksa->rujukan->diagnosa->icd10->diagnosaICD !!})
                        @endif

                        @if(isset( $periksa->suratSakit ))
                            <br> <br>
                            <strong>Surat Keterangan Sakit</strong><br>
                            Tanggal {!! \Carbon\Carbon::parse($periksa->suratSakit->tanggal_mulai)->format('d M Y') !!} selama {!! $periksa->suratSakit->hari !!} hari 
                        @endif

						<br> <br>
						<div class="row">
							@if($periksa->usg)
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<a href="{{ url('usgs/' . $periksa->id) }}" class="btn btn-primary btn-block">Hasil USG</a>
								</div>
							@endif
							@if($periksa->registerAnc)
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<a href="{{ url('ancs/' . $periksa->id) }}" class="btn btn-info btn-block">Hasil ANC</a>
								</div>
							@endif
						</div>
					</td>
					<td>{!! $periksa->terapi_html !!}</td>
				</tr>
				<tr>
					<td>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								  <h2>Transaksi : </h2>
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							</div>
						</div>
					  <table class="table table-condensed">
						<tbody>
                            @foreach ($periksa->transaksii as $t)
                                <tr>
                                    <td colspan="2">{{ $t->jenisTarif->jenis_tarif }}</td>
                                    <td class="text-right uang">{{ $t->biaya }}</td>
                                </tr>
                            @endforeach
						</tbody>
						<tfoot>
						  <tr class="b-top-bold-big">
							<td>Total Biaya Transaksi </td>
							<td>:</td>
							<td  class="text-right">{!! $periksa->total_transaksi !!}</td>
						  </tr>
						</tfoot>
					  </table>
					</td>
					<td>
						<h2>Transaksi</h2>
						 <table class="table table-condensed">
						  <tbody>
							<tr>
							  <td>Pembayaran tunai</td>
							  <td class="uang">{!! $periksa->tunai !!}</td>
							</tr>
							<tr>
							  <td>Pembayaran Piutang</td>
							  <td class="uang">{!! $periksa->piutang !!}</td>
							</tr>
						  </tbody>
						</table>
					</td>
				</tr>
		</tbody>
	</table>
	<div class="row">
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			  <a href="{{ url('pdfs/kuitansi/' . $periksa->id ) }}" class="btn btn-success btn-block" target="_blank">Cetak Kuitansi</a>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			  <a href="{{ url('pdfs/status/' . $periksa->id ) }}" class="btn btn-primary btn-block" target="_blank">Cetak Resep</a>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			  <a href="{{ url('pdfs/struk/' . $periksa->id ) }}" class="btn btn-warning btn-block" target="_blank">Cetak Struk</a>  
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			 @if ( $periksa->ada_hasil_rapid_antibodi )
				  <a href="{{ url('pdfs/rapid/antibodi/' . $periksa->id) }}" class="btn btn-info btn-block" target="_blank">Cetak Rapid Antibodi</a>  
			  @endif
			 @if ( $periksa->ada_hasil_rapid_antigen )
				  <a href="{{ url('pdfs/rapid/antigen/' . $periksa->id) }}" class="btn btn-info btn-block" target="_blank">Cetak Rapid Antigen</a>  
			  @endif
		</div>
	</div>
</div>
