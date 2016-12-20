					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('jenis_tarif_id'))has-error @endif">
							  {!! Form::label('jenis_tarif_id', 'Jenis Tarif', ['class' => 'control-label']) !!}
							  {!! Form::select('jenis_tarif_id' , $jenisTarifList, null, ['class' => 'form-control selectpick rq', 'data-live-search' => 'true']) !!}
							  @if($errors->has('jenis_tarif_id'))<code>{{ $errors->first('jenis_tarif_id') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
							  {!! Form::label('asuransi_id', 'Untuk Asuransi', ['class' => 'control-label']) !!}
								@if( isset($asuransis) ) 
								  {!! Form::select('asuransi_id[]', App\Asuransi::list(), $asuransis, [ // $asuransis = [202];

										  'class'            => 'form-control selectpick rq',
										  'multiple'         => 'multiple',
										  'data-actions-box' => 'true',
										  'data-live-search' => 'true'

								  ]) !!}
							  @else
								  {!! Form::select('asuransi_id[]' , App\Asuransi::list(), null, [

										  'class'            => 'form-control selectpick rq',
										  'multiple'         => 'multiple',
										  'data-actions-box' => 'true',
										  'data-live-search' => 'true'

								  ]) !!}
							  @endif
							  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('discount'))has-error @endif">
							  {!! Form::label('discount', 'Besar Diskon Dalam Persen', ['class' => 'control-label']) !!}
							  <div class="input-group">
								  {!! Form::text('diskon_persen' , null, [
									  'class'           => 'form-control angka text-right rq'
								  ]) !!}
								  @if($errors->has('discount'))<code>{{ $errors->first('discount') }}</code>@endif
									<span class="input-group-addon" id="discountInputGroupAddon"> %</span>
							  </div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('dimulai'))has-error @endif">
							  {!! Form::label('dimulai', 'Tanggal Mulai Diskon', ['class' => 'control-label']) !!}
							  @if( isset( $dimulai ) )
								  {!! Form::text('dimulai' , $dimulai, ['class' => 'form-control tanggal rq']) !!}
							  @else
								  {!! Form::text('dimulai' , null, ['class' => 'form-control tanggal rq']) !!}
							  @endif
							  @if($errors->has('dimulai'))<code>{{ $errors->first('dimulai') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('berakhir'))has-error @endif">
							  {!! Form::label('berakhir', 'Tanggal Terakhir Diskon', ['class' => 'control-label']) !!}

							  @if(isset(  $berakhir  ))
								  {!! Form::text('berakhir' ,  $berakhir, ['class' => 'form-control tanggal rq']) !!}
							  @else
								  {!! Form::text('berakhir' ,  null, ['class' => 'form-control tanggal rq']) !!}
							  @endif
							  @if($errors->has('berakhir'))<code>{{ $errors->first('berakhir') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="row">
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<div class="form-group">
										<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">
											@if(isset( $edit ))
												Update
											@else
												Create
											@endif
										</button>
										{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
									</div> 
								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<a class="btn btn-danger btn-block btn-lg" href="{{ url('generiks') }}">Cancel</a>
								</div>
							</div>
						</div>
					</div>
