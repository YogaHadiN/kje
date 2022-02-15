@extends('layout.master')

@section('title') 
Klinik Jati Elok | Edit Home Visit

@stop
@section('page-title') 
<h2>Create Pasien</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Home Visit</strong>
	  </li>
</ol>

@stop
@section('content') 
		{!! Form::model($home_visit, [
			'url'    => 'home_visits/'. $home_visit->id,
			"class"  => "m-t",
			"role"   => "form",
			"files"  => "true",
			"method" => "put"
		]) !!}
		@include('home_visits.form')
		{!! Form::close() !!}

		{!! Form::open(['url' => 'home_visits/' .$home_visit->id, 'method' => 'delete']) !!}
			{!! Form::submit('Delete', [
				'class'   => 'btn btn-danger btn-block',
				'onclick' => 'return confirm("Anda yakin mau menghapus ' . $home_visit->id . '-' . $home_visit->name.'?");return false;'
			]) !!}
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

