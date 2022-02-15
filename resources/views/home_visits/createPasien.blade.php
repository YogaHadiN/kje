	@extends('layout.master')

	@section('title') 
	Klinik Jati Elok | Create Pasien

	@stop
	@section('page-title') 
	<h2>Create Pasien</h2>
	<ol class="breadcrumb">
		  <li>
			  <a href="{{ url('laporans')}}">Home</a>
		  </li>
		  <li class="active">
			  <strong>Create Pasien</strong>
		  </li>
	</ol>

	@stop
	@section('content') 
			{!! Form::open([
				'url'    => 'home_visits',
				"class"  => "m-t",
				"role"   => "form",
				"files"  => "true",
				"method" => "post"
			]) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						{!! Form::text('nama_pasien', $pasien->nama, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
						<div class="form-group hide @if($errors->has('pasien_id')) has-error @endif">
						  {!! Form::label('pasien_id', 'Pasien', ['class' => 'control-label']) !!}
						  {!! Form::text('pasien_id' , $pasien->id, ['class' => 'form-control']) !!}
						  @if($errors->has('pasien_id'))<code>{{ $errors->first('pasien_id') }}</code>@endif
						</div>
						<div class="form-group @if($errors->has('sistolik')) has-error @endif">
						  {!! Form::label('sistolik', 'Sistolik', ['class' => 'control-label']) !!}
						  {!! Form::text('sistolik' , null, ['class' => 'form-control']) !!}
						  @if($errors->has('sistolik'))<code>{{ $errors->first('sistolik') }}</code>@endif
						</div>
						<div class="form-group @if($errors->has('diastolik')) has-error @endif">
						  {!! Form::label('diastolik', 'Diastolik', ['class' => 'control-label']) !!}
						  {!! Form::text('diastolik' , null, ['class' => 'form-control']) !!}
						  @if($errors->has('diastolik'))<code>{{ $errors->first('diastolik') }}</code>@endif
						</div>
						<div class="form-group @if($errors->has('berat_badan')) has-error @endif">
						  {!! Form::label('berat_badan', 'Berat Badan', ['class' => 'control-label']) !!}
						  {!! Form::text('berat_badan' , null, ['class' => 'form-control']) !!}
						  @if($errors->has('berat_badan'))<code>{{ $errors->first('berat_badan') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
							{!! Form::label('image', 'Image', ['class' => 'control-label']) !!}
							{!! Form::file('image', ['class' => 'form-control']) !!}
								@if (isset($home_visit) && $home_visit->image)
									<p> <img src="{{ \Storage::disk('s3')->url('img/home_visits/'.$home_visit->image) }}" alt="" class="img-rounded upload"> </p>
								@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
								@endif
							{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						@if(isset($update))
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Update</button>
						@else
							<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
						@endif
						{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a class="btn btn-danger btn-block" href="{{ url('home/') }}">Cancel</a>
					</div>
				</div>
			{!! Form::close() !!}
	@stop
	@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(control){
			if(validatePass2(control)){
				$('#submit').click();
			}
		}
	</script>
	@stop
