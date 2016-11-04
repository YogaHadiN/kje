						<div class="row hide">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('pasien_id'))has-error @endif">
								  {!! Form::label('pasien_id', 'Id Pasien', ['class' => 'control-label']) !!}
								  {!! Form::text('pasien_id' , $pasien->id, ['class' => 'form-control']) !!}
								  @if($errors->has('pasien_id'))<code>{{ $errors->first('pasien_id') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('nama'))has-error @endif">
								  {!! Form::label('nama', 'Nama Pasien', ['class' => 'control-label']) !!}
								  {!! Form::text('nama' , $pasien->nama, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
								  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('golongan_prolanis_id'))has-error @endif">
								  {!! Form::label('golongan_prolanis_id', 'Golongan Prolanis', ['class' => 'control-label']) !!}
								  {!! Form::select('golongan_prolanis_id' , $golongan_prolanis, null, ['class' => 'form-control rq']) !!}
								  @if($errors->has('golongan_prolanis_id'))<code>{{ $errors->first('golongan_prolanis_id') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<button class="btn btn-primary btn-block btn-lg" type="button" onclick="dummySubmit(this);return false;">Submit</button>
									{!! Form::submit('Submit', ['class' => 'btn btn-success btn-block btn-lg hide', 'id' => 'submit']) !!}
								</div> 
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<a class="btn btn-danger btn-block btn-lg" href="{{ url('pasiens/' . $pasien->id . '/edit') }}">Cancel</a>
							</div>
						</div>
