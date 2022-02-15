	@extends('layout.master')

	@section('title') 
	Klinik Jati Elok | Create Kunujungan Sehat

	@stop
	@section('page-title') 
	<h2>Create Kunujungan Sehat</h2>
	<ol class="breadcrumb">
		  <li>
			  <a href="{{ url('laporans')}}">Home</a>
		  </li>
		<li>
			  <a href="{{ url('home_visits')}}">Home Visit</a>
		  </li>
		  <li class="active">
			  <strong>Create Kunujungan Sehat</strong>
		  </li>
	</ol>

	@stop
	@section('content') 
		@include('pasiens.form', ['createLink' => true])
	@stop
	@section('footer') 
		<script src="{!! url('js/twbs-pagination/jquery.twbsPagination.min.js') !!}"></script>
		{!! HTML::script('js/pasiens.js')!!}
		{!! HTML::script('js/home_visit_create.js')!!}
	@stop
