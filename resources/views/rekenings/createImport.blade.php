@extends('layout.master')

@section('title') 
{{ \Auth::user()->tenant->name }} | Import Transaksi

@stop
@section('page-title') 
<h2>Import Transaksi</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Import Transaksi</strong>
	  </li>
</ol>

@stop
@section('content') 
{!! Form::open(array(
    "url"    => "rekenings/import",
    "class"  => "m-t",
    "role"   => "form",
    "method" => "post",
    "files"  => "true"
)) !!}
		<div class="form-group{{ $errors->has('transaksi') ? ' has-error' : '' }}">
			{!! Form::label('transaksi', 'Transaksi') !!}
			{!! Form::file('transaksi') !!}
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<button class="btn btn-success btn-block" type="button" onclick='dummySubmit(this);return false;'>Submit</button>
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
