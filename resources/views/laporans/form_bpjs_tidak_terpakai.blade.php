<div class="table-responsive">
	<table class="table table-hover table-condensed DT">
		<thead>
			<tr>
				<th>Informasi</th>
				<th>Status</th>
				<th>Terapi</th>
			</tr>
		</thead>
		<tbody>
				@foreach($ks as $px)
					<tr
		
						@if($px->pcare_submit == '2')
							class="warning"
						@elseif($px->pcare_submit == '3')
							class="danger"
						@endif
					>
						<td>
							<strong>Tanggal</strong><br />
							{{ $px->created_at->format('d-m-Y') }}<br />
							{{ $px->pcare_submit }}
							<strong>Jam</strong><br />
							{{ $px->created_at->format('H:i:s') }}<br /><br />
							{{ $px->periksa->pasien->nama }} <br />
							<strong>({{ $px->periksa->pasien_id }})</strong> <br /><br />
							<strong>Nomor BPJS :</strong> <br />
							{{ $px->periksa->pasien->nomor_asuransi_bpjs }} <br /><br />
							<strong>Pembayaran saat ini :</strong> <br />
							{{ $px->periksa->asuransi->nama }} <br />
							<a class="btn btn-info btn-lg btn-block" href="{{ url('pasiens/' . $px->periksa->pasien_id . '/edit') }}">Detail</a>
						</td>
						<td>
							<strong>Anemnesa :</strong> <br />
							{{ $px->periksa->anamnesa }} <br /><br />
							<strong>Pemeriksaan Fisik, Penunjang dan Tindakan :</strong> <br />
							{{ $px->periksa->pemeriksaan_fisik }} <br />{{ $px->periksa->pemeriksaan_penunjang }} <br /><br />
							<strong>Diagnosa : </strong> <br />
							{{  $px->periksa->diagnosa->diagnosa  }}
							{{ $px->periksa->diagnosa->icd10_id }} - {{ $px->periksa->diagnosa->icd10->diagnosaICD }}

						</td>
						<td>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									{!! $px->periksa->terapi_html !!} 
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<br />
									{!! Form::open(['url' => 'laporans/kunjungansakit', 'method' => 'post', 'autocomplete' => 'off']) !!}
										{!! Form::text('id', $px->id, ['class' => 'form-control hide']) !!}
										{!! Form::text('nama', $px->periksa->pasien->nama, ['class' => 'hide nama']) !!}
										{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
										{!! Form::text('kunjungan_sehat', '1', ['class' => 'form-control hide kunjungan_sehat']) !!}
										{!! Form::select('pcare_submit', $pcare_submits, $px->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
										{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
									{!! Form::close() !!}
								</div>
							</div>

						</td>
					</tr>
				@endforeach
		</tbody>
	</table>
</div>
