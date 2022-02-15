@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buat Diskon Baru

@stop
@section('page-title') 
<h2>Buat Diskon Baru</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Buat Diskon Baru</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Buat Diskon Baru</div>
				</div>
				<div class="panel-body">
					{!! Form::open(['url' => 'discounts', 'method' => 'post']) !!}
					@include('discounts.form')
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

