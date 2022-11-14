@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Input Service AC

@stop
@section('page-title') 
<h2>Input Service AC</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Input Service AC</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open([
		'url' => 'pengeluarans/service_acs', 
		'method' => 'post',
		'files' => 'true'
	]) !!}
<div class="row">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Input Service AC</div>
		</div>
		<div class="panel-body">
			<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group @if($errors->has('ac_id[]'))has-error @endif">
							  {!! Form::label('ac_id[]', 'Ac yang di service', ['class' => 'control-label']) !!}
							  {!! Form::select('ac_id[]' , App\Models\Ac::list(), null, [
								  'class'            => 'form-control selectpick rq',
								  'multiple'         => 'multiple',
								  'data-actions-box' => 'true',
								  'data-live-search' => 'true'
							  ]) !!}
							  @if($errors->has('ac_id[]'))<code>{{ $errors->first('ac_id[]') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('tanggal'))has-error @endif">
							  {!! Form::label('tanggal', 'Tanggal Diservice', ['class' => 'control-label']) !!}
							  {!! Form::text('tanggal' , null, ['class' => 'form-control tanggal rq']) !!}
							  @if($errors->has('tanggal'))<code>{{ $errors->first('tanggal') }}</code>@endif
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group @if($errors->has('biaya'))has-error @endif">
							  {!! Form::label('biaya', 'Biaya', ['class' => 'control-label']) !!}
							  {!! Form::text('biaya' , null, ['class' => 'form-control uangInput rq']) !!}
							  @if($errors->has('biaya'))<code>{{ $errors->first('biaya') }}</code>@endif
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div  class="form-group @if($errors->has('supplier_id'))has-error @endif">
							  {!! Form::label('supplier_id', 'Nama Supplier', ['class' => 'control-label']) !!}
							  {!! Form::select('supplier_id' , App\Models\Supplier::list(), null, [
								  'class' => 'form-control selectpick rq',
								  'data-live-search' => 'true'
							  ]) !!}
							  @if($errors->has('supplier_id'))<code>{{ $errors->first('supplier_id') }}</code>@endif
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
					<div>
						<div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
							{!! Form::label('image', 'Input Gambar Kuitansi') !!}
							{!! Form::file('image') !!}
								@if (isset($ac) && $ac->image)
									<p> <img src="{{ \Storage::disk('s3')->url('img/belanja/service_ac/'.$ac->image) }}" alt="" class="img-rounded upload"> </p>
								@else
									<p> <img src="{{ \Storage::disk('s3')->url('img/photo_not_available.png') }}" alt="" class="img-rounded upload"> </p>
								@endif
							{!! $errors->first('image', '<p class="help-block">:message</p>') !!}
						</div>
					</div>			
				</div>
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

