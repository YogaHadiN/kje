<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('merek'))has-error @endif">
				  {!! Form::label('merek', 'Merek', ['class' => 'control-label']) !!}
				  {!! Form::text('merek' , null, ['class' => 'form-control rq']) !!}
				  @if($errors->has('merek'))<code>{{ $errors->first('merek') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="form-group @if($errors->has('keterangan'))has-error @endif">
				  {!! Form::label('keterangan', 'Keterangan Lokasi', ['class' => 'control-label']) !!}
				  {!! Form::textarea('keterangan' , null, ['class' => 'form-control textareacustom rq']) !!}
				  @if($errors->has('keterangan'))<code>{{ $errors->first('keterangan') }}</code>@endif
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="form-group">
					<button class="btn btn-success btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Submit</button>
					{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
				</div> 
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a class="btn btn-danger btn-block btn-lg" href="{{ url('generiks') }}">Cancel</a>
			</div>
		</div>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
			{!! Form::label('image', 'Input Gambar AC', ['class' => 'control-label']) !!}
			{!! Form::file('image', ['class' => 'form-control']) !!}
				@if (isset($ac) && $ac->image)
					<p> <img src="{{ \Storage::disk('s3')->url('img/ac/'.$ac->image) }}" alt="" class="img-rounded upload"> </p>
				@else
					<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
				@endif
			{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
</div>
