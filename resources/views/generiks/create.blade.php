@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Generik Baru

@stop
@section('page-title') 
<h2>Buat Generik Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Generik Baru</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Buat Generik Baru</div>
		</div>
		<div class="panel-body">
			{!! Form::open(['url' => 'generiks', 'method' => 'post']) !!}
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('generik'))has-error @endif">
						  {!! Form::label('generik', 'Nama Generik', ['class' => 'control-label']) !!}
						  {!! Form::text('generik' , null, ['class' => 'form-control rq']) !!}
						  @if($errors->has('generik'))<code>{{ $errors->first('generik') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('pregnancy_safety_index'))has-error @endif">
						  {!! Form::label('pregnancy_safety_index', 'Pregnancy Safety Index', ['class' => 'control-label']) !!}
						  {!! Form::text('pregnancy_safety_index' , null, ['class' => 'form-control']) !!}
						  @if($errors->has('pregnancy_safety_index'))<code>{{ $errors->first('pregnancy_safety_index') }}</code>@endif
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
			{!! Form::close() !!}
		</div>
	</div>
	
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

