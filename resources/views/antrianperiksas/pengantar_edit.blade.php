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
	{{--<div class="panel panel-success">--}}
		{{--<div class="panel-heading">--}}
			{{--<div class="panel-title">Edit Pengantar Pasien</div>--}}
		{{--</div>--}}
		{{--<div class="panel-body">--}}
			{{--<div class="table-responsive">--}}
				{{--<table id="table_pengantar" class="table table-hover table-condensed">--}}
					{{--<thead>--}}
						{{--<tr>--}}
							{{--<th>Nama</th>--}}
							{{--<th>BPJS</th>--}}
							{{--<th>KTP</th>--}}
							{{--<th>Action</th>--}}
						{{--</tr>--}}
					{{--</thead>--}}
					{{--<tbody>--}}
						{{--@if($antrianpoli->antars->count() > 0)--}}
							{{--@foreach($antrianpoli->antars as $antar)--}}
								{{--<tr>--}}
									{{--<td>{{ $antar->pengantar->nama}}</td>--}}
									{{--<td> <img src="{{ url('/' . $antar->pengantar->bpjs_image ) }}" alt="" class="img-rounded upload" />   </td>--}}
									{{--<td> <img src="{{ url('/' . $antar->pengantar->ktp_image ) }}" alt="" class="img-rounded upload" />   </td>--}}
									{{--<td> <a class="btn btn-primary btn-xs" href="#">Edit</a> </td>--}}
								{{--</tr>--}}
							{{--@endforeach--}}
						{{--@else--}}
							{{--<tr>--}}
								{{--<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>--}}
							{{--</tr>--}}
						{{--@endif--}}
					{{--</tbody>--}}
				{{--</table>--}}
			{{--</div>--}}
			
		{{--</div>--}}
	{{--</div>--}}


	{!! Form::open(['url' => 'antrianperiksas/pengantar/' . $ap->id . '/edit', 'method' => 'post', 'files' => 'true']) !!}
	@include('antrianpolis.pengantar_form', [
		'pengantar' => 'true',
		'edit' => true,
		'antrianperiksa' => true,
		'halamanAwal' => 'antrian_periksa_id',
		'polii' => $ap->poli
	])
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

