@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Edit Pengantar Pasien

@stop

@section('head') 
	<style type="text/css" media="all">

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
			 width: 5%;
		}
		
	</style>

@stop

@section('page-title') 
<h2>Edit Pengantar Pasien</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Edit Pengantar Pasien</strong>
	  </li>
</ol>

@stop
@section('content') 
	{!! Form::open(['url' => 'laporans/periksa/pengantar/' . $ap->id , 'method' => 'post', 'files' => 'true']) !!}
	@include('antrianpolis.pengantar_form', ['pengantar' => 'true', 'edit' => true, 'halamanAwal' => 'periksa_id'])
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

