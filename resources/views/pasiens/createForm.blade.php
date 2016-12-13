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
						  	{!! Form::label('image', 'Foto Wajah Pasien') !!}
						  	{!! Form::file('image') !!}
						  		@if (isset($pasien) && $pasien->image)
						  			<p> {!! HTML::image(asset($pasien->image), null, ['class'=>'img-rounded upload']) !!} </p>
						  		@else
						  			<p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
						  		@endif
						  	{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
						  </div>
					  </div>
				  </div>
				 <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('ktp_image') ? ' has-error' : '' }}">
							 {!! Form::label('ktp_image', 'Upload Gambar KTP') !!}
							 {!! Form::file('ktp_image') !!}
							 @if (isset($pasien) && $pasien->ktp_image)
								 <p> {!! HTML::image(asset($pasien->ktp_image), null, ['class'=>'img-rounded upload']) !!} </p>
							 @else
								 <p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
							 @endif
							 {!! $errors->first('ktp_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
				 <div class="row">
					 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						 <div class="form-group{{ $errors->has('bpjs_image') ? ' has-error' : '' }}">
							 {!! Form::label('bpjs_image', 'Upload Kartu BPJS') !!}
							 {!! Form::file('bpjs_image') !!}
							 @if (isset($pasien) && $pasien->bpjs_image)
								 <p> {!! HTML::image(asset($pasien->bpjs_image), null, ['class'=>'img-rounded upload']) !!} </p>
							 @else
								 <p> {!! HTML::image(asset('img/photo_not_available.png'), null, ['class'=>'img-rounded upload']) !!} </p>
							 @endif
							 {!! $errors->first('bpjs_image', '<p class="help-block">:message</p>') !!}
						 </div>
					 </div>
				 </div>
			</div>
		@endif
		 </div>
		 <div class="panel-footer">
		 	<div class="row">
		 		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<button class="btn btn-success btn-lg btn-block" 
				 @if(isset($pengantar)) 
					type="button" onclick="pasiensCreate();return false;" 
				 @else 
					 type="submit" 
				 @endif 
			 > Submit </button>
		 		</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a class="btn btn-danger btn-lg btn-block" href="{{ url('pasiens') }}">Cancel</a>
		 		</div>
		 	</div>
		 </div>
	 </div>
 </div>
