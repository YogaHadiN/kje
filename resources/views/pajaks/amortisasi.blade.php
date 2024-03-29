@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Amortisasi

@stop
@section('page-title') 
<h2>Pelaporan Amortisasi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Amortisasi</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Laporan Amortisasi</h3>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'pajaks/amortisasiPost', 'method' => 'post']) !!}
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group @if($errors->has('tahun'))has-error @endif">
								  {!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
									{!! Form::select('tahun', $lists, null, array(
										'class'         => 'form-control rq'
									))!!}
								  @if($errors->has('tahun'))<code>{{ $errors->first('tahun') }}</code>@endif
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
								<a class="btn btn-danger btn-block" href="{{ url('home') }}">Cancel</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
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
