@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Pembayaran Dokter

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
		  <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover " id="tableAsuransi">
                  <thead>
                    <tr>
                    	<th>ID</th>
                    	<th>
                            Tanggal
                            {!! Form::text('id', null, ['class' => 'ajaxChange form-control', 'id' => 'id']) !!}
                        </th>
                    	<th>
                            Nama Dokter
                            {!! Form::text('nama_dokter', null, ['class' => 'ajaxChange form-control', 'id' => 'nama_dokter']) !!}
                        </th>
                    	<th>
                            Pembayaran
                            {!! Form::text('pembayaran', null, ['class' => 'ajaxChange form-control', 'id' => 'pembayaran']) !!}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bayardokters as $bayar)
                        <tr>
                            <td>{!! $bayar->id !!}</td>
                            <td>{!! $bayar->created_at !!}</td>
                            <td>{!! $bayar->nama !!}</td>
                            <td class="uang">{!! $bayar->nilai !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
		  </div>
      </div>
</div>
@stop
@section('footer') 
	
@stop


