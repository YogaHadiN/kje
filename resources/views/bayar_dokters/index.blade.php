@extends('layout.master')

@section('title') 
Klinik Jati Elok | Pembayaran Dokter

@stop
@section('page-title') 
<h2>Bayar Dokter</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
        <li>
          <a href="{{ url('stafs')}}">Staf</a>
      </li>
      <li class="active">
          <strong>Pembayaran Dokter</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                </div>
                <div class="panelRight">
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-striped table-bordered table-hover " id="tableAsuransi">
                  <thead>
                    <tr>
                    	<th>ID</th>
                    	<th>Tanggal</th>
                    	<th>Nama Dokter</th>
                    	<th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bayardokters as $bayar)
                        <tr>
                            <td>{!! $bayar->id !!}</td>
                            <td>{!! $bayar->created_at->format('d-m-Y') !!}</td>
                            <td>{!! $bayar->staf->nama !!}</td>
                            <td class="uang">{!! $bayar->bayar_dokter !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
      </div>
</div>


@stop
@section('footer') 
	
@stop


