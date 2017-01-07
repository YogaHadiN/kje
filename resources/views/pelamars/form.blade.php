<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('nama'))has-error @endif">
		  {!! Form::label('nama', 'Nama Pelamar', ['class' => 'control-label']) !!}
		  {!! Form::text('nama' , null, ['class' => 'form-control rq']) !!}
		  @if($errors->has('nama'))<code>{{ $errors->first('nama') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('no_telp'))has-error @endif">
		  {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
		  {!! Form::text('no_telp' , null, ['class' => 'form-control rq']) !!}
		  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group @if($errors->has('no_ktp'))has-error @endif">
		  {!! Form::label('no_ktp', 'Nomor KTP', ['class' => 'control-label']) !!}
		  {!! Form::text('no_ktp' , null, ['class' => 'form-control rq']) !!}
		  @if($errors->has('no_ktp'))<code>{{ $errors->first('no_ktp') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
			{!! Form::label('image', 'Upload Gambar KTP Pelamar') !!}
			{!! Form::file('image') !!}
				@if (isset($pelamar) && $pelamar->image)
					<p> {!! HTML::image(asset('img/pelamar/'.$pelamar->image), null, ['class'=>'img-rounded upload']) !!} </p>
				@else
					<p> {!! HTML::image(asset('img/camera_photo_not_found.jpeg'), null, ['class'=>'img-rounded upload']) !!} </p>
				@endif
			{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<div class="form-group">
			<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Submit</button>
			@if(isset($update))
				{!! Form::submit('Update', ['class' => 'hide', 'id' => 'submit']) !!}
			@else
				{!! Form::submit('Submit', ['class' => 'hide', 'id' => 'submit']) !!}
			@endif
		</div> 
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<a class="btn btn-danger btn-block btn-lg" href="{{ url('laporans') }}">Cancel</a>
	</div>
</div>
</div>
