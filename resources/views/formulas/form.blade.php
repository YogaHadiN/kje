        <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <div class="panel panel-success">
                <div class="panel-heading">
                     <div class="panelLeft">
                        <h3 class="panel-title"> Komposisi Obat</h3>
                     </div>
                     <div class="panelRight">
                        <button class='btn btn-primary' type='button' onclick='show_dose();'>Lihat Dosis</button>                         
                     </div>

                </div>
                <div class="panel-body">
                    <table id='komposisiByIDFormula' class='table table-condensed'>
                        <thead>
                            <tr>
                                <th>Nama Generik</th>
                                <th colspan="2">Bobot</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="ajax1">
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td >
                                    {!! Form::select('ddlGenerik', $generik, null, ['id' => 'ddlGenerik', 'class' => 'form-control selectpick', 'data-live-search'=> "true", 'data-style' => 'btn-white'])!!}
                                </td>
                                <td>
                                    <input type="text" class="form-control kosong" id="txtBobot" placeholder="bobot.." aria-describedby="basic-addon2" />
                                </td>
                                <td>
                                    <select id="slcSatuan" class="form-control">
                                        <option value="mg">mg</option>
                                        <option value="gr">gr</option>
                                        <option value="ui">ui</option>
                                        <option value="mcg">mcg</option>
                                        <option value="%">%</option>
                                        <option value="mg/ml">mg/ml</option>
                                    </select>
                                </td>
                                <td><a href="#" class="btn btn-success btn-sm" id="inputKomposisi">input</a></td>
                            </tr>
                        </tfoot>
                    </table>
                    {!! Form::textarea('json', null, ['class' => 'hide', 'id' => 'json'])!!}
                </div>
            </div>

            </div>
        </div>
            <div class="row" id='dosis_row'>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                     <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"> Dosis Obat  </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							
                            <div class="form-group">
                                {!!Form::label('kg6_7')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg6_7', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg6_7', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg6_7', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg6_7_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg6_7'))
                                    <code>{!! $errors->first('kg6_7') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg7_9')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg7_9', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg7_9', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg7_9', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg7_9_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg7_9'))
                                    <code>{!! $errors->first('kg7_9') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg9_13')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg9_13', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg9_13', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg9_13', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg9_13_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg9_13'))
                                    <code>{!! $errors->first('kg9_13') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg13_15')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg13_15', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg13_15', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg13_15', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg13_15_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg13_15'))
                                    <code>{!! $errors->first('kg13_15') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg15_19')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg15_19', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg15_19', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg15_19', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg15_19_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg15_19'))
                                    <code>{!! $errors->first('kg15_19') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg19_23')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg19_23', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg19_23', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg19_23', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg19_23_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg19_23'))
                                    <code>{!! $errors->first('kg19_23') !!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg23_26')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg23_26', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg23_26', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg23_26', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg23_26_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg23_26'))
                                    <code>{!! $errors->first('kg23_26') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg26_30')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg26_30', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg26_30', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg26_30', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg26_30_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg26_30'))
                                    <code>{!! $errors->first('kg26_30') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg30_37')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg30_37', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg30_37', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg30_37', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg30_37_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg30_37'))
                                    <code>{!! $errors->first('kg30_37') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg37_45')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg37_45', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg37_45', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg37_45', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg37_45_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg37_45'))
                                    <code>{!! $errors->first('kg37_45') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg45_50')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg45_50', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg45_50', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg45_50', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg45_50_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg45_50'))
                                    <code>{!! $errors->first('kg45_50') !!}</code>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('kg50')!!}<br />
								<div class="table-responsive">
									<table class="table table-condensed dosis">
										<thead>
											<tr>
												<th>Signa</th>
												<th>Jumlah</th>
												<th>Puyer Jumlah</th>
												<th>Jumlah BPJS</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{!! Form::select('signa_kg50', $signas, null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg50', null, ['class' => 'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_puyer_kg50', null, ['class' =>'form-control'])!!}</td>
												<td>{!! Form::text('jumlah_kg50_bpjs', null, ['class' => 'form-control'])!!}</td>
											</tr>
										</tbody>
									</table>
								</div>
                                @if($errors->first('kg50'))
                                    <code>{!! $errors->first('kg50') !!}</code>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
