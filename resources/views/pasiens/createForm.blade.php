 <div class="row">
	<div class="panel panel-info">
		<div class="panel-body">
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				 <div class="row">
				 	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						@if( isset( $alamatPasien ) )
							@include('pasiens.modal_insert', ['facebook' => !$antrianpolis, $alamatPasien])    
						@else
							@include('pasiens.modal_insert', ['facebook' => !$antrianpolis])    
						@endif
				 	</div>
				 </div>
			</div>
			@if( !isset($pengantar) )
			 <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				  <div class="row">
					  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						  <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
							{!! Form::label('image', 'Foto Wajah Pasien', ['class' => 'control-label']) !!}
							@if (isset( $pasien->image ) && Storage::disk('s3')->exists($pasien->image))
								{!! Form::file('image', ['class' => 'form-control']) !!}
							@elseif( isset($pasien) )
								{!! Form::file('image', ['class' => 'form-control']) !!}
							@else
								{!! Form::file('image', ['class' => 'form-control rq']) !!}
							@endif
						  		@if (isset($pasien) && $pasien->image)
									<p> <img src="{{ \Storage::disk('s3')->url($pasien->image) }}" alt="" class="img-rounded upload"> </p>
						  		@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
						  		@endif
						  	{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
						  </div>
					  </div>
				  </div>
				 <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
							 {!! Form::label('ktp_image', 'Upload Gambar KTP', ['class' => 'control-label']) !!}
							 {!! Form::file('ktp_image', ['class' => 'form-control']) !!}
							 @if (isset($pasien) && $pasien->ktp_image)
								 <p> <img src="{{ \Storage::disk('s3')->url($pasien->ktp_image) }}" alt="" class="img-rounded upload"> </p>
							 @else
								 <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
							 @endif
							 {!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
				 <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
							 {!! Form::label('bpjs_image', 'Upload Kartu BPJS', ['class' => 'control-label']) !!}
							 {!! Form::file('bpjs_image', ['class' => 'form-control']) !!}
							 @if (isset($pasien) && $pasien->bpjs_image)
								 <p> <img src="{{ \Storage::disk('s3')->url($pasien->bpjs_image) }}" alt="" class="img-rounded upload"> </p>
							 @else
								 <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
							 @endif
							 {!! $errors->first('bpjs_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
				<div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('kartu_asuransi_image') ? ' has-error' : '' }}">
							 {!! Form::label('kartu_asuransi_image', 'Upload Kartu Asuransi', ['class' => 'control-label']) !!}
							 {!! Form::file('kartu_asuransi_image', ['class' => 'form-control']) !!}
							 @if (isset($pasien) && $pasien->kartu_asuransi_image)
								 <p> <img src="{{ \Storage::disk('s3')->url($pasien->kartu_asuransi_image) }}" alt="" class="img-rounded upload"> </p>
							 @else
								 <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
							 @endif
							 {!! $errors->first('kartu_asuransi_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
				<div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('prolanis_ht_flagging_image') ? ' has-error' : '' }}">
							 {!! Form::label('prolanis_ht_flagging_image', 'Upload Gambar Prolanis HT') !!}
							 {!! Form::file('prolanis_ht_flagging_image') !!}
							 @if (isset($pasien) && $pasien->prolanis_ht_flagging_image)
								 <p> <img src="{{ \Storage::disk('s3')->url($pasien->prolanis_ht_flagging_image) }}" alt="" class="img-rounded upload"> </p>
							 @else
								 <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
							 @endif
							 {!! $errors->first('prolanis_ht_flagging_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
				<div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('prolanis_dm_flagging_image') ? ' has-error' : '' }}">
							 {!! Form::label('prolanis_dm_flagging_image', 'Upload Gambar Prolanis DM') !!}
							 {!! Form::file('prolanis_dm_flagging_image') !!}
							 @if (isset($pasien) && $pasien->prolanis_dm_flagging_image)
								 <p> <img src="{{ \Storage::disk('s3')->url($pasien->prolanis_dm_flagging_image) }}" alt="" class="img-rounded upload"> </p>
							 @else
								 <p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
							 @endif
							 {!! $errors->first('prolanis_dm_flagging_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
			</div>
		@endif
		 </div>
		 <div class="panel-footer">
			 <div class="row">
			 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<button class="btn btn-success btn-block" type="button"
						 @if(isset($pengantar)) 
							 onclick="pasiensCreate();return false;" >
							@if(isset($pasien))
								Update
							@else
								Submit
							@endif
						</button>
						 @else 
							 onclick="dummySubmit(this);return false;">
							@if(isset($pasien))
								Update
							@else
								Submit
							@endif
							</button>
							{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
						 @endif 
			 	</div>
			 	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			 		<a class="btn btn-danger btn-block" href="{{ url('pasiens') }}">Cancel</a>
			 	</div>
			 </div>
		 </div>
	 </div>
 </div>
 <script type="text/javascript" charset="utf-8">
	function dummySubmit(control){
		if(validatePass2(control)){
			$('#submit').click();
		}
	}
 </script>
