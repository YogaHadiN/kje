<div class="panel panel-info">
		<div class="panel-body">
			<div class="pg_id hide">
				{{ $fb->id }}
			</div>
			<div class="nilai hide">
				{{ $fb->nilai }}
			</div>
			<div class="keterangan hide">
				{{ $fb->keterangan }}
			</div>
			<div class="tanggal-db hide">
				{{ $fb->tanggal }}
			</div>
			<div class="sumber_uang_id hide">
				{{ $fb->sumber_uang_id }}
			</div>
			<div class="supplier_id hide">
				{{ $fb->supplier_id }}
			</div>
			<div class="faktur_image hide">
				{{ $fb->faktur_image }}
			</div>
			<div class="staf_id hide">
				{{ $fb->staf_id }}
			</div>
			<div class="created_at hide">
				{{ $fb->created_at }}
			</div>
			<div class="table-responsive">
				<div class="row">
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
						<table class="table table-hover table-condensed table-bordered table-keterangan">
							<thead>
								<tr>
									<th>Keterangan</th>
									<th>Tanggal</th>
									<th>Nilai</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ $fb->keterangan }}</td>
									<td>{{App\Models\Classes\Yoga::updateDatePrep(  $fb->tanggal  )}}</td>
									<td class="text-right">{{App\Models\Classes\Yoga::buatrp(  $fb->nilai  )}}</td>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group @if($errors->has('nomor_faktur'))has-error @endif">
									{!! Form::label('nomor_faktur[]', 'Nomor Faktur', ['class' => 'control-label']) !!}
									{!! Form::text('nomor_faktur[]', null, array(
										'class'         => 'form-control rq'
									))!!}
								  @if($errors->has('nomor_faktur'))<code>{{ $errors->first('nomor_faktur') }}</code>@endif
								</div>
							</div>
							@if( $ikhtisar != 'service_ac' )
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
								<div class="alert alert-danger info_uang_sama">
									<h3 class="uang_total text-right">Rp. 0,-</h3>
									<i>Nilai Belum Sama</i>
								</div>
							</div>
							@endif
						</div>
						<div class="table-responsive">
							@if($ikhtisar == 'alat')
								<table class="table table-hover table-condensed table-bordered table-alat">
									<thead>
										<tr>
											<th>Nama Peralatan</th>
											<th>Harga Satuan</th>
											<th>Jumlah</th>
											<th>Kelompok Penyusutan</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspann="3"></td>	
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td> {!! Form::text('peralatan', null, ['class' => 'form-control peralatan']) !!} </td>	
											<td> {!! Form::text('harga_satuan', null, ['class' => 'form-control harga_satuan uangInput']) !!} </td>	
											<td> {!! Form::text('jumlah', null, ['class' => 'form-control jumlah angka']) !!} </td>	
											<td> {!! Form::select('masa_pakai', App\Models\Classes\Yoga::masaPakai(), null, ['class' => 'form-control masa_pakai']) !!} </td>	
											<td> <button class="btn btn-info btn-sm btn-block" type="button" onclick="inp(this);return false;">Input</button> </td>	
										</tr>
									</tfoot>
								</table>
							@elseif( $ikhtisar == 'bahan_bangunan' )
								<table class="table table-hover table-condensed table-bordered table-alat">
									<thead>
										<tr>
											<th>Nama Bahan Bangunan</th>
											<th>Harga Satuan</th>
											<th>Jumlah</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
									<tfoot>
										<tr>
											<td> {!! Form::text('keterangan', null, ['class' => 'form-control keterangan']) !!} </td>	
											<td> {!! Form::text('harga_satuan', null, ['class' => 'form-control harga_satuan uangInput']) !!} </td>	
											<td> {!! Form::text('jumlah', null, ['class' => 'form-control jumlah angka']) !!} </td>	
											<td> <button class="btn btn-info btn-sm btn-block" type="button" onclick="inp(this);return false;">Input</button> </td>	
										</tr>
									</tfoot>
								</table>
							@elseif(   $ikhtisar == 'service_ac' )
								<table class="table table-hover table-condensed table-bordered table-alat">
									<thead>
										<tr>
											<th>Ac yang diservis</th>
											<th>Keterangan kerusakan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspann="3"></td>	
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<td> {!! Form::select('ac_id', App\Models\Ac::list(), null, ['class' => 'form-control ac_id']) !!} </td>	
											<td> {!! Form::text('keterangan', null, ['class' => 'form-control kerusakan']) !!} </td>	
											<td> <button class="btn btn-info btn-sm btn-block" type="button" onclick="inp(this);return false;">Input</button> </td>	
										</tr>
									</tfoot>
								</table>
							@endif
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<a target="_blank" class="" href="{{ \Storage::disk('s3')->url('img/belanja/lain/' . $fb->faktur_image) }}">
							<img src="{{ \Storage::disk('s3')->url('img/belanja/lain/' . $fb->faktur_image) }}" class="img-responsive img-rounded">
						</a>
					</div>
				</div>
			</div>
	{!! Form::textarea('temp[]',null, ['class' => 'temp hide']) !!}
	</div>
	</div>
