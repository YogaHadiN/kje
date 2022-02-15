@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pasien

@stop
@section('page-title') 
<h2>List Semua Pasien</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Pasien</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : </h3>
                </div>
                <div class="panelRight">
                   <a href='{{ url("asuransis/create") }}' type="button" class="btn btn-success" ><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ASURANSI Baru</a>

                </div>
            </div>
      </div>
	  <div class="panel-body">
			{!! $html->table( ['class' => 'table table-condensed'] ) !!} 
	  </div>
</div>


@stop
@section('footer') 

	{!! $html->scripts() !!}

	
@stop
