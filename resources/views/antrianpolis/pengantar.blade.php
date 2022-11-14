@extends('layout.master')

@section('title') 
	{{ ucwords( \Auth::user()->tenant->name ) }} | Input Pengantar Pasien
@stop
@section('head') 
    <link href="{!! asset('js/select2/dist/css/select2.min.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/select2-bootstrap-theme/dist/select2-bootstrap.css') !!}" rel="stylesheet">
	<style type="text/css" media="all">
		.select2-result-repository { padding-top: 4px; padding-bottom: 3px; }
		.select2-result-repository__avatar { float: left; width: 60px; margin-right: 10px; }
		.select2-result-repository__avatar img { width: 100%; height: auto; border-radius: 2px; }
		.select2-result-repository__meta { margin-left: 70px; }
		.select2-result-repository__title { color: black; font-weight: bold; word-wrap: break-word; line-height: 1.1; margin-bottom: 4px; }
		.select2-result-repository__forks, .select2-result-repository__stargazers { margin-right: 1em; }
		.select2-result-repository__forks, .select2-result-repository__stargazers, .select2-result-repository__watchers { display: inline-block; color: #aaa; font-size: 11px; }
		.select2-result-repository__description { font-size: 13px; color: #777; margin-top: 4px; }
		.select2-results__option--highlighted .select2-result-repository__title { color: white; }
		.select2-results__option--highlighted .select2-result-repository__forks, .select2-results__option--highlighted .select2-result-repository__stargazers, .select2-results__option--highlighted .select2-result-repository__description, .select2-results__option--highlighted .select2-result-repository__watchers { color: #c6dcef; }
		#table_pengantar tr td:first-child, #table_pengantar tr th:first-child {
			 width: 10%;
		}

		#table_pengantar tr td:nth-child( 2 ), #table_pengantar tr th:nth-child( 2 ) {
			 width: 40%;
		}

		#table_pengantar tr td:nth-child( 3 ), #table_pengantar tr th:nth-child( 3 ) {
			 width: 40%;
		}
		
		#table_pengantar tr td:nth-child( 4 ), #table_pengantar tr th:nth-child( 4 ) {
			 width: 10%;
		}
	</style>


@stop
@section('page-title') 
<h2>Input Pengantar Pasien</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Input Pengantar Pasien</strong>
	  </li>
</ol>
@stop
@section('content') 
	{!! Form::open(['url' => $posisi_antrian .'/pengantar/' . $id, 'method' => 'post', 'files' => 'true']) !!}
	@include('antrianpolis.pengantar_form', ['pengantar' => true])
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		var base = "{{ url('/') }}";
	</script>
	{!! HTML::script('js/pasiens.js')!!}
	{!! HTML::script('js/rowEntryPengantar.js')!!}
	{!! HTML::script('js/select2/dist/js/select2.min.js')!!}
	{!! HTML::script('js/pengantar.js')!!}
@stop

