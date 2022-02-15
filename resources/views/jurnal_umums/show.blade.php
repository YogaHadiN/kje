@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Jurnal Umum
@stop
@section('page-title') 
 <h2>Jurnal Umum</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Jurnal Umum</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $jurnalumums->count() !!}</h3>
                </div>
                <div class="panelRight">
					<a class="btn btn-info" target="_blank" href="{{ url('pdfs/jurnal_umum/' .$bulan . '/' . $tahun) }}">Bentuk PDF</a>
                </div>
            </div>
      </div>
      <div class="panel-body">
            {!! $jurnalumums->appends(Input::except('page'))->links(); !!}
            @include('jurnal_umums.jurnal_template')
            {!! $jurnalumums->appends(Input::except('page'))->links(); !!}
      </div>
</div>
@stop
@section('footer') 

@stop

