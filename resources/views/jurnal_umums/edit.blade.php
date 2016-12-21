@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Jurnal

@stop
@section('page-title') 
<h2>Edit Jurnal</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Jurnal</strong>
	  </li>
</ol>

@stop
@section('content') 
<div class="row">
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Edit Jurnal</div>
			</div>
			<div class="panel-body">
				{!! Form::open(['url' => 'jurnal_umums/'.$ju->id, 'method' => 'put']) !!}
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('jurnalable_type'))has-error @endif">
						  {!! Form::label('jurnalable_type', 'Jurnalable Type', ['class' => 'control-label']) !!}
						  {!! Form::text('jurnalable_type' , $ju->jurnalable_type, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
						  @if($errors->has('jurnalable_type'))<code>{{ $errors->first('jurnalable_type') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('jurnalable_id'))has-error @endif">
							{!! Form::label('jurnalable_id', 'Jurnalable Id', ['class' => 'control-label']) !!}
						  {!! Form::text('jurnalable_id' , $ju->jurnalable_id, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
						  @if($errors->has('jurnalable_id'))<code>{{ $errors->first('jurnalable_id') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('coa'))has-error @endif">
						  {!! Form::label('coa', 'Cos', ['class' => 'control-label']) !!}
						  {!! Form::text('coa' , $ju->coa->coa, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
						  @if($errors->has('coa'))<code>{{ $errors->first('coa') }}</code>@endif
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group @if($errors->has('debit'))has-error @endif">
						  {!! Form::label('debit', 'Debit', ['class' => 'control-label']) !!}
						  {!! Form::text('debit' , $ju->debit, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
						  @if($errors->has('debit'))<code>{{ $errors->first('debit') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="form-group @if($errors->has('nilai'))has-error @endif">
						  {!! Form::label('nilai', 'Nilai', ['class' => 'control-label']) !!}
						  {!! Form::text('nilai' , $ju->nilai, ['class' => 'form-control rq']) !!}
						  @if($errors->has('nilai'))<code>{{ $errors->first('nilai') }}</code>@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="form-group">
							<button class="btn btn-primary btn-block btn-lg" type="button" onclick="dummySubmit();return false;">Update</button>
							{!! Form::submit('submit', ['class' => 'hide', 'id' => 'submit']) !!}
						</div> 
					</div>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">Jurnal Umum</div>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					@include('periksas.jurnals', ['periksa' => $ju->jurnalable_type::find($ju->jurnalable_id)])
				</div>
			</div>
		</div>
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

