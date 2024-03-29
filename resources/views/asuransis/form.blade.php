<div class="panel panel-default">
    <div class="panel-body">
        <div role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" id="tab2panel">
                <li role="presentation" class="active">
                    <a href="#Asuransi" aria-controls="Asuransi" role="tab" data-toggle="tab">Asuransi</a>
                </li>
                <li role="presentation">
                    <a href="#Tarif" aria-controls="Tarif" role="tab" data-toggle="tab">Tarif</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="Asuransi">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<div class="form-group @if($errors->has('nama'))has-error @endif">
									  {!! Form::label('nama', 'Nama Asuransi', ['class' => 'control-label', 'style' => 'text-align:left']) !!}
                                        {!! Form::text('nama', null, array(
                                            'class'         => 'form-control rq',
                                            'placeholder'   => 'Nama Asuransi'
                                            ))!!}
									  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
									</div>
                                    </div>
                                </div>
								@if( isset($asuransi) )
									<div class="row hide">
										  {!! Form::text('asuransi_id', $asuransi->id, array(
												'class' => 'form-control',
												'id'    => 'asuransi_id'
											))!!}
									</div>
								@endif
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="form-group @if($errors->has('alamat'))has-error @endif">
										  {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
                                            {!! Form::textarea('alamat', null, array(
                                                'class'         => 'form-control textareacustom',
                                                'placeholder'   => 'Alamat'
                                                ))!!}
										  @if($errors->has('alamat'))<code>{{ $errors->first('alamat') }}</code>@endif
										</div>
                                        </div>
                                    </div>
										<div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('kata_kunci'))has-error @endif">
												  {!! Form::label('kata_kunci', 'Kata Kunci', ['class' => 'control-label']) !!}
                                                    {!! Form::text('kata_kunci', null, array(
                                                        'class'         => 'form-control kata_kunci',
                                                        'id'         => 'kata_kunci',
                                                        'placeholder'   => 'Kata Kunci Transfer Bank'
                                                        ))!!}
												  @if($errors->has('kata_kunci'))<code>{{ $errors->first('kata_kunci') }}</code>@endif
												</div>
											</div>
										</div>
										@if( isset($asuransi) )
											@include('asuransis.upload', ['models' => 'asuransis', 'folder' => 'asuransi'])
										@endif
									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<div class="form-group @if($errors->has('kali_obat'))has-error @endif">
												  {!! Form::label('kali_obat', 'Pengali Obat', ['class' => 'control-label']) !!}
												  @if(isset($asuransi))
													  {!! Form::text('kali_obat' ,null, ['class' => 'form-control numeric rq']) !!}
												  @else
													  {!! Form::text('kali_obat' ,'1.25', ['class' => 'form-control numeric rq']) !!}
												  @endif
												  @if($errors->has('kali_obat'))<code>{{ $errors->first('kali_obat') }}</code>@endif
												</div>
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<div class="form-group @if($errors->has('telpon'))has-error @endif">
												  {!! Form::label('telpon', 'Nomor Telepon', ['class' => 'control-label']) !!}
													<div class="table-responsive">
													<table class="table table-hover table-condensed table-bordered" id="table_pic">
														<tbody>
															@if( isset($asuransi) && $asuransi->telpons->count() > 0)
																@foreach($asuransi->telpons as $k => $telpon)	
																	<tr>
																		<td>
																			<div class="form-group">
																				{!! Form::text('telpon[]', $telpon->nomor, array(
																					'class'         => 'form-control',
																					'placeholder'   => 'No Telp'
																					))!!}
																			</div>
																		</td>
																		<td class="column-fit">
																			@if( $k == $asuransi->telpons->count() - 1 && $asuransi->telpons->count() > 1 )
																				<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																				</button>
																				&nbsp
																				<button type="button" class="btn btn-danger" onclick="kurangInput(this); return false;">
																					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
																				</button>
																			@elseif( $k == $asuransi->telpons->count() - 1 && $asuransi->telpons->count() == 1   )
																				<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																				</button>
																			@else
																				<button type="button" class="btn btn-danger" onclick="kurangInput(this); return false;">
																					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
																				</button>
																			@endif
																		</td>
																	</tr>
																@endforeach
																@else
																	<tr>
																		<td>
																			<div class="form-group">
																				{!! Form::text('telpon[]', null, array(
																					'class'         => 'form-control',
																					'placeholder'   => 'No Telp'
																					))!!}
																			</div>
																		</td>
																		<td class="column-fit">
																			<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																			</button>
																		</td>
																	</tr>
																@endif
														</tbody>
													</table>
												</div>
												  @if($errors->has('telpon'))<code>{{ $errors->first('telpon') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<div class="form-group @if($errors->has('tipe_asuransi_id'))has-error @endif">
												  {!! Form::label('tipe_asuransi_id', 'Tipe Asuransi', ['class' => 'control-label']) !!}
													{!! Form::select('tipe_asuransi_id', $tipe_asuransi_list, null, array(
														'class'         => 'form-control rq',
														'placeholder'   => '- Pilih Tipe Asuransi -'
														))!!}
												  @if($errors->has('tipe_asuransi_id'))<code>{{ $errors->first('tipe_asuransi_id') }}</code>@endif
												</div>
											</div>
											<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
												<div class="form-group @if($errors->has('tanggal_berakhir'))has-error @endif">
												  {!! Form::label('tanggal_berakhir', 'Tangggal Berakhir', ['class' => 'control-label']) !!}
													{!! Form::text('tanggal_berakhir', $tanggal, array(
														'class'         => 'form-control tanggal',
														'placeholder'   => 'tanggal_berakhir'
														))!!}
												  @if($errors->has('tanggal_berakhir'))<code>{{ $errors->first('tanggal_berakhir') }}</code>@endif
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											  {!! Form::label('pics', 'PIC', ['class' => 'control-label']) !!}
												<div class="table-responsive">
													<table class="table table-hover table-condensed table-bordered" id="table_pic">
														<tbody>
															@if( isset($asuransi) && $asuransi->pic->count() > 0)
																@foreach($asuransi->pic as $k => $pic)	
																	<tr>
																		<td>
																			<div class="form-group">
																				{!! Form::text('pic[]', $pic->nama, array(
																					'class'         => 'form-control pic',
																					'placeholder'   => 'nama'
																				))!!}
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				{!! Form::text('hp_pic[]', $pic->nomor_telepon, array(
																					'class'         => 'form-control phone',
																					'placeholder'   => 'phone'
																				))!!}
																			</div>
																		</td>
																		<td class="column-fit">
																			@if( $k == $asuransi->pic->count() - 1 && $asuransi->pic->count() > 1 )
																				<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																				</button>
																				&nbsp
																				<button type="button" class="btn btn-danger" onclick="kurangInput(this); return false;">
																					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
																				</button>
																			@elseif( $k == $asuransi->pic->count() - 1 && $asuransi->pic->count() == 1   )
																				<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																				</button>
																			@else
																				<button type="button" class="btn btn-danger" onclick="kurangInput(this); return false;">
																					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
																				</button>
																			@endif
																		</td>
																	</tr>
																@endforeach
																@else
																	<tr>
																		<td>
																			<div class="form-group">
																				{!! Form::text('pic[]','', array(
																					'class'         => 'form-control',
																					'placeholder'   => 'nama'
																				))!!}
																			</div>
																		</td>
																		<td>
																			<div class="form-group">
																				{!! Form::text('hp_pic[]', null, array(
																					'class'         => 'form-control phone',
																					'placeholder'   => 'nomor'
																				))!!}
																			</div>
																		</td>
																		<td class="column-fit">
																			<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																			</button>
																		</td>
																	</tr>
																@endif
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
												<div class="table-responsive">
													<table class="table table-hover table-condensed table-bordered" id="table_email">
														<tbody>
															@if( isset($asuransi) && $asuransi->emails->count() > 0) 
																@foreach($asuransi->emails as $k => $email)	
																	<tr>
																		<td>
																			<div class="form-group">
																				{!! Form::text('email[]', $email->email, array(
																					'class'         => 'form-control email',
																					'placeholder'   => 'email'
																				))!!}
																			</div>
																		</td>
																		<td class="column-fit">
																			@if( $k == $asuransi->emails->count() - 1 && $asuransi->emails->count() > 1 )
																				<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																				</button>
																				&nbsp
																				<button type="button" class="btn btn-danger" onclick="kurangInput(this); return false;">
																					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
																				</button>
																			@elseif( $k == $asuransi->emails->count() - 1 && $asuransi->emails->count() == 1   )
																				<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																				</button>
																			@else
																				<button type="button" class="btn btn-danger" onclick="kurangInput(this); return false;">
																					<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
																				</button>
																			@endif
																		</td>
																	</tr>
																@endforeach
															@else
																<tr>
																	<td>
																		<div class="form-group">
																			{!! Form::text('email[]', null, array(
																				'id'          => 'email',
																				'class'       => 'form-control email',
																				'placeholder' => 'email'
																			))!!}
																		</div>
																	</td>
																	<td class="column-fit">
																		<button type="button" class="btn btn-primary" onclick="tambahInput(this); return false;">
																			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
																		</button>
																	</td>
																</tr>
															@endif
														</tbody>
													</table>
												</div>
												</div>
											</div>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group @if($errors->has('aktif')) has-error @endif">
                                                      {!! Form::label('aktif', 'Aktif', ['class' => 'control-label']) !!}
                                                      {!! Form::select('aktif', [ 
                                                              0 => 'Tidak Aktif',
                                                              1 => 'Aktif',
                                                          ], null, array(
                                                            'id'          => 'aktif',
                                                            'class'       => 'form-control'
                                                      ))!!}
                                                  @if($errors->has('aktif'))<code>{{ $errors->first('aktif') }}</code>@endif
                                                </div>
											</div>
                                        </div>
                                        <div class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-group @if($errors->has('tarif_tersendiri')) has-error @endif">
                                                  {!! Form::label('tarif_tersendiri', 'Tarif tersendiri', ['class' => 'control-label']) !!}
                                                  {!! Form::select('tarif_tersendiri', [ 
                                                          0 => 'tidak',
                                                          1 => 'Ya',
                                                      ], isset($asuransi)? $asuransi->tarif_tersendiri : 0, array(
                                                        'id'          => 'tarif_tersendiri',
                                                        'placeholder'          => '- Pilih -',
                                                        'class'       => 'form-control'
                                                  ))!!}
                                                  @if($errors->has('tarif_tersendiri'))<code>{{ $errors->first('tarif_tersendiri') }}</code>@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							<div role="tabpanel" class="tab-pane" id="Tarif">
                                <div class="row">
                                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                        Menampilkan <span id="rows"></span> hasil
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 padding-bottom">
                                        {!! Form::select('displayed_rows', App\Models\Classes\Yoga::manyRows(), 15, [
                                            'class'    => 'form-control',
                                            'onchange' => 'clearAndSearch();return false;',
                                            'id'       => 'displayed_rows'
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                   Jenis Tarif<br>
                                                   {!! Form::select('jenis_tarif_id', \App\Models\JenisTarif::pluck('jenis_tarif', 'id'), null, [
                                                        'class'            => 'form-control-inline form-control selectpick',
                                                        'placeholder'      => '- Pilih -',
                                                        'id'               => 'sp_jenis_tarif_id',
                                                        'data-live-search' => 'true',
                                                        'onchange'         => 'viewTarif(); return false;'
                                                   ])!!}
                                                </th>
                                                <th>
                                                   Biaya<br>
                                                   {!! Form::text('biaya', null, [
                                                        'class' => 'form-control-inline form-control',
                                                        'id' => 'sp_biaya',
                                                        'onkeyup' => 'viewTarif(); return false;'
                                                   ])!!}
                                                </th>
                                                <th>
                                                   Jasa Dokter<br>
                                                   {!! Form::text('jasa_dokter', null, [
                                                        'class' => 'form-control-inline form-control',
                                                        'id' => 'sp_jasa_dokter',
                                                        'onkeyup' => 'viewTarif(); return false;'
                                                   ])!!}
                                                </th>
                                                <th>
                                                   Tipe Tindakan<br>
                                                   {!! Form::select('tipe_tindakan_id', \App\Models\TipeTindakan::pluck('tipe_tindakan', 'id'), null, [
                                                        'class' => 'form-control-inline form-control selectpick',
                                                        'placeholder'      => '- Pilih -',
                                                        'id' => 'sp_tipe_tindakan_id',
                                                        'onchange'         => 'viewTarif(); return false;'
                                                   ])!!}
                                                </th>
                                                <th>Action</th>
                                                <th class="hide key">id</th>
                                                <th class="hide">tipe_tindakan_id</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tarifContainer">
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div id="page-box">
                                                <nav class="text-right" aria-label="Page navigation" id="paging">
                                                
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>
						@if(isset($asuransi))
							Update
						@else
							Submit
						@endif
							</button>
						{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a class="btn btn-danger btn-block" href="{{ url('asuransis') }}">Cancel</a>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide">
						@if(isset($asuransi))
							<textarea name="tarifs" id="tarifs" rows="8" cols="40">{{ $tarifs }}</textarea>
						@else
							<textarea name="tarifs" id="tarifs" rows="8" cols="40">{{ json_encode($tarifs) }}</textarea>
						@endif
					</div>
				</div>
			</div>
