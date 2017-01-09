@extends('layout.master')

@section('title') 
Klinik Jati Elok | Test

@stop

@section('page-title') 
@section('head') 
    <link href="{!! asset('js/Ajax-Bootstrap-Select/dist/css/ajax-bootstrap-select.min.css') !!}" rel="stylesheet">
@stop
<h2>Test</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Test</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Test</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group @if($errors->has('test'))has-error @endif">
					  {!! Form::label('test', 'Test', ['class' => 'control-label']) !!}
					  <select class="form-control selectpickerAjax with-ajax" name="this" data-live-search="true">
					  </select>
					  @if($errors->has('test'))<code>{{ $errors->first('test') }}</code>@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	
@stop
@section('footer') 
{!! HTML::script('js/Ajax-Bootstrap-Select/dist/js/ajax-bootstrap-select.min.js')!!}
<script type="text/javascript" charset="utf-8">
	var base = "{{ url('/') }}";
</script>
{!! HTML::script('js/ajax.js')!!}
@stop
		
