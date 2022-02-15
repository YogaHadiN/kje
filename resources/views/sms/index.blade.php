@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | SMS
@stop
@section('page-title') 
<h2>SMS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>SMS</strong>
	  </li>
</ol>
@stop
@section('content') 
	{!! Form::open(['url' => 'sms', 'method' => 'post']) !!}
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<h1>SMS</h1>	
								<p>dari nomor {{ env('TWILLIO_NUMBER') }}</p>
								<hr />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('nomor'))has-error @endif">
								  {!! Form::label('nomor', 'Nomor Handphone', ['class' => 'control-label']) !!}
								  {!! Form::text('nomor' , null, ['class' => 'form-control']) !!}
								  @if($errors->has('nomor'))<code>{{ $errors->first('nomor') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('pesan'))has-error @endif">
								  {!! Form::label('pesan', 'Pesan', ['class' => 'control-label']) !!}
								  {!! Form::textarea('pesan' , null, ['class' => 'form-control textareacustom']) !!}
								  @if($errors->has('pesan'))<code>{{ $errors->first('pesan') }}</code>@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
								  {!! Form::submit('Submit', ['class' => 'btn btn-success btn-block btn-lg']) !!}
								</div> 
							</div>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
								<a class="btn btn-danger btn-block btn-lg" href="{{ url('laporans') }}">Cancel</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop
@section('footer') 
	
@stop
