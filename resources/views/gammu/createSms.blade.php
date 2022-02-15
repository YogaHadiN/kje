@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat SMS Gammu

@stop
@section('page-title') 
<h2>Buat SMS Gammu</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat SMS Gammu</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open(['url' => 'gammu/send/sms', 'method' => 'post']) !!}

		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('text'))has-error @endif">
						  {!! Form::label('text', 'Pesan', ['class' => 'control-label']) !!}
						  {!! Form::textarea('text' , null, ['class' => 'form-control textareacustom rq']) !!}
						  @if($errors->has('text'))<code>{{ $errors->first('text') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('no_telp'))has-error @endif">
						  {!! Form::label('no_telp', 'Nomor Telepon Tujuan', ['class' => 'control-label']) !!}
						  {!! Form::text('no_telp' , null, ['class' => 'form-control rq']) !!}
						  @if($errors->has('no_telp'))<code>{{ $errors->first('no_telp') }}</code>@endif
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
						<a class="btn btn-danger btn-block btn-lg" href="{{ url('gammu/inbox') }}">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		
	{!! Form::close() !!}
	
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
@stop

