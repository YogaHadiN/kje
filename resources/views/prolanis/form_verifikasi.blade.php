<h3>Ditemukan {{ count($prolanis) }} data</h3>
	<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered table-striped">
			<thead>
				<tr>
					<th>Nomor</th>
					<th>Nama
						 <br>Excel
					</th>
					<th>Usia
						 <br>Excel
					</th>
					<th>Alamat
						 <br>Excel
					</th>
					<th>Jenis Kelamin
						 <br>Excel
					</th>
					<th>Nama</th>
					<th>Usia</th>
					<th>Alamat</th>
					<th>Nomor BPJS</th>
					<th>Meninggal</th>
					<th>Penangguhan</th>
					<th>Verifikasi</th>
					{{-- <th>DM</th> --}}
					{{-- <th>HT</th> --}}
				</tr>
			</thead>
			<tbody>
				@if(count($prolanis) > 0)
					@foreach($prolanis as $k => $p)
						<tr
						    @if ( isset( $p->pasienProlanis->first()->pasien ))
								@if ($kategori_prolanis == 'dm')
									@if ( $p->pasienProlanis->first()->pasien->verifikasi_prolanis_dm_id == '2')
										class="success"
									@elseif( $p->pasienProlanis->first()->pasien->verifikasi_prolanis_dm_id == '3')
										class="danger"
									@endif
								@elseif ($kategori_prolanis == 'ht')
									@if ( $p->pasienProlanis->first()->pasien->verifikasi_prolanis_ht_id == '2')
										class="success"
									@elseif( $p->pasienProlanis->first()->pasien->verifikasi_prolanis_ht_id == '3')
										class="danger"
									@endif
								@endif
							@endif
						>
							<td rowspan="{{ $p->pasienProlanis->count() ? $p->pasienProlanis->count() : 1 }}">
								{{ $k + 1 }}
							</td>
							<td rowspan="{{ $p->pasienProlanis->count() ? $p->pasienProlanis->count() : 1 }}">{{ $p->nama }} <br>({{ strlen($p->nama) }} karakter)</td>
							<td rowspan="{{ $p->pasienProlanis->count() ? $p->pasienProlanis->count() : 1 }}">{{ $p->usia }}</td>
							<td rowspan="{{ $p->pasienProlanis->count() ? $p->pasienProlanis->count() : 1 }}">{{ $p->alamat }}</td>
							<td rowspan="{{ $p->pasienProlanis->count() ? $p->pasienProlanis->count() : 1 }}">{{ $p->jenis_kelamin }}</td>
							@foreach ($p->pasienProlanis as $k => $pp)
								@if ($k !== 0)
								 </tr><tr 
									@if ( isset( $pp->pasien ))

										@if ($kategori_prolanis == 'dm')
											@if ( $pp->pasien->verifikasi_prolanis_dm_id == '2')
												class="success"
											@elseif( $pp->pasien->verifikasi_prolanis_dm_id == '3')
												class="danger"
											@endif
										@elseif ($kategori_prolanis == 'ht')
											@if ( $pp->pasien->verifikasi_prolanis_ht_id == '2')
												class="success"
											@elseif( $pp->pasien->verifikasi_prolanis_ht_id == '3')
												class="danger"
											@endif
										@endif
											@endif
											 >
								@endif
								<td>
										<a href="{{ url('pasiens/'. $pp->pasien_id . '/edit') }}" target="_blank">
											{{ $pp->pasien->nama }} </br> 
											({{ strlen($pp->pasien->nama) }} karakter)
										</a>
								</td>
								<td>
									{{ \App\Models\Classes\Yoga::umurSaatPeriksa( $pp->pasien->tanggal_lahir, $p->periode ) }}
								</td>
								<td class="hide pasien_id">
									{{ $pp->pasien->id }}
								</td>
								<td class="hide kategori_prolanis">
									{{ $kategori_prolanis }}
								</td>
								<td>
									{{ $pp->pasien->alamat }}
								</td>
								<td>
									{{ $pp->pasien->nomor_asuransi_bpjs }}
								</td>
								<td nowrap class="autofit">
									{!! Form::select('meninggal', [
											 0 => 'No',
											 1 => 'Meninggal'
										], $pp->pasien->meninggal, [
										'class'    => 'form-control meninggal',
										'onchange' => 'changeMeninggal(this)'
									]) !!}
								</td>
								<td nowrap class="autofit">
									{!! Form::select('penangguhan', [
											 0 => 'No',
											 1 => 'Penangguhan'
										], $pp->pasien->penangguhan_pembayaran_bpjs, [
										'class'    => 'form-control penangguhan',
										'onchange' => 'changePenangguhan(this)'
									]) !!}
								</td>
								<td nowrap class="autofit">
									{!! Form::select('verifikasi_prolanis_id', $verifikasi_prolanis_options, $pp->pasien->$verifikasi_prolanis_kategori_id, [
										'class'    => 'form-control verifikasi',
										'onchange' => 'changeVerifikasi(this)'
									]) !!}
								</td>
							@endforeach
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="7" class="text-center">Tidak ada data untuk ditampilkan</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	<h3>Pasien Yang Ada Ditemukan {{ count($pasiens) }} data</h3>

		<div class="table-responsive">
			<table class="table table-hover table-condensed table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Tanggal Lahir</th>
						<th>Prolanis DM</th>
						<th>Prolanis HT</th>
						<th>Nomor Bpjs</th>
						{{-- <th>Action</th> --}}
					</tr>
				</thead>
				<tbody>
					@if(count($pasiens) > 0)
						@foreach($pasiens as $k=> $p)
							<tr>
								<td>{{ $k + 1 }}</td>
								<td>
									<a href="{{ url('pasiens/'. $p->id . '/edit') }}" target="_blank">
										{{ $p->nama }}
									</a>
								</td>
								<td>{{ $p->tanggal_lahir->format('Y-m-d') }}</td>
								<td>{{ $p->prolanis_dm ? 'Ya' : 'Tidak' }}</td>
								<td>{{ $p->prolanis_ht ? 'Ya' : 'Tidak' }}</td>
								<td>{{ $p->nomor_asuransi_bpjs }}</td>
								{{-- <td> --}}
								{{-- 	{!! Form::select('verifikasi_prolanis_id', $verifikasi_prolanis_options, null, ['class' => 'form-control']) !!} --}}
								{{-- </td> --}}
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4" class="text-center">Tidak ada data untuk ditampilkan</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
