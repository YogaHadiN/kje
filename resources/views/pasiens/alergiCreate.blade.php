@extends('layout.master')

@section('title') 
Klinik Jati Elok | Alergi Obat

@stop
@section('page-title') 
<h2>Alergi Obat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
		<li>
			<a href="{{ url('pasiens/' . $pasien->id . '/alergi')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Alergi Baru</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Alergi Obat {{ $pasien->nama }}</h3>
		</div>
		<div class="panel-body">
			{!! Form::open(['url' => 'pasiens/' . $pasien->id . '/alergi', 'method' => 'post']) !!}
				<div class="form-group @if($errors->has('generik_id')) has-error @endif">
				  {!! Form::label('generik_id', 'Nama Generik', ['class' => 'control-label']) !!}
				  {!! Form::select('generik_id' , $generik_list, null, ['class' => 'form-control selectpick']) !!}
				  @if($errors->has('generik_id'))<code>{{ $errors->first('generik_id') }}</code>@endif
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
						{!! Form::submit('Submit', ['class' => 'btn btn-success hide', 'id' => 'submit']) !!}
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<a class="btn btn-danger btn-block" href="{{ url('home') }}">Cancel</a>
					</div>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
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

