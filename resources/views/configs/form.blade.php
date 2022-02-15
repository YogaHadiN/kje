<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('config_variable'))has-error @endif">
		  {!! Form::label('config_variable', 'Variabel', ['class' => 'control-label']) !!}
			{!! Form::text('config_variable', null, array(
				'class'         => 'form-control'
			))!!}
		  @if($errors->has('config_variable'))<code>{{ $errors->first('config_variable') }}</code>@endif
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="form-group @if($errors->has('value'))has-error @endif">
		  {!! Form::label('value', 'Nilai', ['class' => 'control-label']) !!}
			{!! Form::text('value',  null, array(
				'class'         => 'form-control rq'
			))!!}
		  @if($errors->has('value'))<code>{{ $errors->first('value') }}</code>@endif
		</div>
	</div>
</div>
@if( \Auth::user()->role == '6' )
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="form-group @if($errors->has('rahasia'))has-error @endif">
			  {!! Form::label('rahasia', 'RAHASIA', ['class' => 'control-label']) !!}
			  {!! Form::text('rahasia', [ 0 => 'Tidak Rahasia', 1 => 'RAHASIA' ], 0, array(
					'class'         => 'form-control',
				))!!}
			  @if($errors->has('rahasia'))<code>{{ $errors->first('rahasia') }}</code>@endif
			</div>
		</div>
	</div>
@endif
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		@if(isset($config))
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
		@else
			<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
		@endif
		{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
	</div>
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<a class="btn btn-danger btn-block" href="{{ url('configs') }}">Cancel</a>
	</div>
</div>
