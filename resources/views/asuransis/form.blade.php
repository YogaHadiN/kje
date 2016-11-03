
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
                                            'class'         => 'form-control',
                                            'placeholder'   => 'Nama Asuransi'
                                            ))!!}
									  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
									</div>
                                    </div>
                                </div>
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
											<div class="form-group @if($errors->has('umum'))has-error @endif">
											  {!! Form::label('umum', 'Umum', ['class' => 'control-label']) !!}
                                                {!! Form::textarea('umum', $umumstring, array(
                                                    'class'         => 'form-control textareacustom',
                                                    'placeholder'   => 'Umum'
                                                    ))!!}
											  @if($errors->has('umum'))<code>{{ $errors->first('umum') }}</code>@endif
											</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="form-group @if($errors->has('gigi'))has-error @endif">
												  {!! Form::label('gigi', 'Gigi', ['class' => 'control-label']) !!}
                                                    {!! Form::textarea('gigi', $gigistring, array(
                                                        'class'         => 'form-control textareacustom',
                                                        'placeholder'   => 'Gigi'
                                                        ))!!}
												  @if($errors->has('gigi'))<code>{{ $errors->first('gigi') }}</code>@endif
												</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('pic'))has-error @endif">
													  {!! Form::label('pic', 'PIC', ['class' => 'control-label']) !!}
														{!! Form::text('pic',null, array(
															'class'         => 'form-control',
															'placeholder'   => 'PIC'
															))!!}
													  @if($errors->has('pic'))<code>{{ $errors->first('pic') }}</code>@endif
													</div>
												</div>
											</div>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group @if($errors->has('kali_obat'))has-error @endif">
													  {!! Form::label('kali_obat', 'Pengali Obat', ['class' => 'control-label']) !!}
													  {!! Form::text('kali_obat' , '1.25', ['class' => 'form-control']) !!}
													  @if($errors->has('kali_obat'))<code>{{ $errors->first('kali_obat') }}</code>@endif
													</div>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

													<div class="form-group @if($errors->has('no_telp'))has-error @endif">
													  {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                                                        {!! Form::text('no_telp', null, array(
                                                            'class'         => 'form-control',
                                                            'placeholder'   => 'No Telp'
                                                            ))!!}
													  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group @if($errors->has('hp_pic'))has-error @endif">
													  {!! Form::label('hp_pic', 'HP PIC', ['class' => 'control-label']) !!}
														{!! Form::text('hp_pic', null, array(
															'class'         => 'form-control',
															'placeholder'   => 'HP PIC'
															))!!}
													  @if($errors->has('hp_pic'))<code>{{ $errors->first('hp_pic') }}</code>@endif
													</div>
												</div>
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group @if($errors->has('tipe_asuransi'))has-error @endif">
													  {!! Form::label('tipe_asuransi', 'Tipe Asuransi', ['class' => 'control-label']) !!}
														{!! Form::select('tipe_asuransi',array(
															null => '- Tipe Asuransi -',
															'1' => 'Admedika',
															'2' => 'Kapitasi',
															'3' => 'Perusahaan',
															'4' => 'Flat',
															'5' => 'BPJS',
															), null, array(
															'class'         => 'form-control',
															'placeholder'   => 'tipe_asuransi'
															))!!}
													  @if($errors->has('tipe_asuransi'))<code>{{ $errors->first('tipe_asuransi') }}</code>@endif
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
												<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
													<div class="form-group @if($errors->has('email'))has-error @endif">
													  {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
														{!! Form::email('email', null, array(
															'class'         => 'form-control',
															'placeholder'   => 'Email'
															))!!}
													  @if($errors->has('email'))<code>{{ $errors->first('email') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('penagihan'))has-error @endif">
													  {!! Form::label('penagihan', 'Penagihan', ['class' => 'control-label']) !!}
														{!! Form::textarea('penagihan', $penagihanstring, array(
															'class'         => 'form-control textareacustom',
															'placeholder'   => 'penagihan'
															))!!}
													  @if($errors->has('penagihan'))<code>{{ $errors->first('penagihan') }}</code>@endif
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
													<div class="form-group @if($errors->has('rujukan'))has-error @endif">
													  {!! Form::label('rujukan', 'Rujukan', ['class' => 'control-label']) !!}
														{!! Form::textarea('rujukan', $rujukanstring, array(
															'class'         => 'form-control textareacustom',
															'placeholder'   => 'Rujukan'
															))!!}
													  @if($errors->has('rujukan'))<code>{{ $errors->first('rujukan') }}</code>@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<div role="tabpanel" class="tab-pane" id="Tarif">
								<div class="panel panel-info">
									<div class="panel-heading">
										<h3>TARIF</h3>
									</div>
									<div class="panel-body">
										<!-- Table -->
										<table class="table table-condensed table-bordered DT">
											<thead>
												<tr>
													<th>Jenis Tarif</th>
													<th>Biaya</th>
													<th>Jasa Dokter</th>
													<th>Tipe Tindakan</th>
													<th>Action</th>
													<th class="hide">id</th>
												</tr>
											</thead>
											<tbody id="tblTarif">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				{!! Form::submit($submit, array(
					'class' => 'btn btn-primary block full-width m-b'
					))!!}
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				{!! HTML::link('asuransis', 'Cancel', ['class' => 'btn btn-danger btn-block'])!!}
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				{!! Form::textarea('tarifs', $tarifs, ['class' => 'form-control hide', 'id' => 'tarifs'])!!}
			</div>
		</div>
