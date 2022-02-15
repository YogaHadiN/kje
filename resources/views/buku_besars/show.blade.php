@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Buku Besar

@stop
@section('page-title') 

@section('head') 
	<style type="text/css" media="all">

		 #table_buku_besar td, #table_buku_besar th {

			/* css-3 */
			white-space: -o-pre-wrap; 
			word-wrap: break-word;
			white-space: pre-wrap; 
			white-space: -moz-pre-wrap; 
			white-space: -pre-wrap; 

		}
		#table_buku_besar { 
		  table-layout: fixed;
		  width: 100%
		}

		#table_buku_besar td:first-child, #table_buku_besar th:first-child { 
		  width: 5%
		}
		#table_buku_besar td:nth-child(2), #table_buku_besar th:nth-child(2) { 
		  width: 10%
		}
		#table_buku_besar td:nth-child( 3 ), #table_buku_besar th:nth-child( 3 ) { 
		  width: 40%
		}

		#table_buku_besar td:nth-child( 4 ), 
		#table_buku_besar td:nth-child( 5 ), 
		#table_buku_besar td:nth-child( 6 ), 
		#table_buku_besar td:nth-child( 7 ), 
		#table_buku_besar th:nth-child( 4 ) 
		#table_buku_besar th:nth-child( 5 ) 
		#table_buku_besar th:nth-child( 6 ) 
		#table_buku_besar th:nth-child( 7 ) 
		{ 
			white-space:nowrap;
			
		}
	</style>
@stop
 <h2>List Buku Besar</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Buku Besar</strong>
      </li>
</ol>
@stop
@section('content') 
  <div class="panel panel-info">
    <div class="panel-heading">
		<h3 class="panel-title">
			<div class="panelLeft">
				Buku Besar : {{ $coa->coa }}
			</div>
			<div class="panelRight">
				<a class="btn btn-warning" target="_blank" href="{{ url('pdfs/buku_besar/' . $bulan . '/' . $tahun . '/' . $coa_id) }}">Bentuk PDF</a>
			</div>
		</h3>
    </div>
	<div class="panel-body">
		@include('buku_besars.form')
	</div>
  </div>
@stop
@section('footer') 
<script>
  function dummySubmit(){
    if (validatePass()) {
      $('#submit').click();
    }
  }
</script>

@stop
