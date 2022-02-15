@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Create Prolanis

@stop
@section('page-title') 
<h2>Create Prolanis</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Create Prolanis</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Create Prolanis</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'prolanis', 'method' => 'post']) !!}
						@include('prolanis.form')
					{!! Form::close() !!}
				</div>
			</div>
			
		</div>
	</div>
@stop
@section('footer') 
<script type="text/javascript" charset="utf-8">
	function dummySubmit(control){
		if( validatePass() ){
			$('#submit').click();
		}
	}
	
	
</script>
	
@stop

