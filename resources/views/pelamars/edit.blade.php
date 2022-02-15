@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Pelamar

@stop
@section('page-title') 
<h2>Edit Pelamar</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Pelamar</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">Edit Pelamar</div>
				</div>
				<div class="panel-body">
				{!! Form::model($pelamar, [
					'url'    => 'pelamars',
					'files'  => 'true',
					'method' => 'post'
				]) !!}
						@include('pelamars.form', ['update'=> true])
					{!! Form::close() !!}
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

