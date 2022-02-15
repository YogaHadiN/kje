@extends('layout.master')

@section('title') 
Klinik Jati Elok | Cari Transaksi

@stop
@section('page-title') 
<h2>Cari Transaksi</h2>
<ol class="breadcrumb">
            <li>
                <a href="{{ url('laporans')}}">Home</a>
            </li>
            <li class="active">
                <strong>Cari Transaksi</strong>
            </li>
</ol>
<style type="text/css" media="screen">
#table_cari_transaksi th:nth-child(1), 
#table_cari_transaksi td:nth-child(1), 
#table_cari_transaksi th:nth-child(3), 
#table_cari_transaksi td:nth-child(3), 
#table_cari_transaksi th:nth-child(4), 
#table_cari_transaksi td:nth-child(4), 
#table_cari_transaksi th:nth-child(5), 
#table_cari_transaksi td:nth-child(5), 
#table_cari_transaksi th:nth-child(6), 
#table_cari_transaksi td:nth-child(6){
  width : 15%;
}

  
</style>

@stop
@section('content') 
<div class="table-responsive">
    <table class="table table-hover table-condensed table-bordered" id="table_cari_transaksi">
        <thead>
            <tr>
                <th>
                   Tanggal 
                      <br>
                      {!! Form::text('tanggal', null, [
                          'class' => 'form-control tanggal parameter'
                      ]) !!}
                </th>
                <th>
                  Nama Pasien
                  <br>
                  {!! Form::text('nama_pasien', null, [
                      'class' => 'form-control nama_pasien parameter'
                  ]) !!}
                </th>
                <th>
                  Nama Asuransi
                  <br>
                  {!! Form::text('nama_asuransi', null, [
                      'class' => 'form-control nama_asuransi parameter'
                  ]) !!}
                </th>
                <th>
                  Tunai
                  <br>
                  {!! Form::text('tunai', null, [
                      'class' => 'form-control tunai parameter'
                  ]) !!}
                </th>
                <th>
                  Piutang
                  <br>
                  {!! Form::text('piutang', null, [
                      'class' => 'form-control piutang parameter'
                  ]) !!}
                </th>
                <th>
                    Sudah Dibayar
                  <br>
                  {!! Form::text('sudah_dibayar', null, [
                      'class' => 'form-control sudah_dibayar parameter'
                  ]) !!}
                </th>
            </tr>
        </thead>
        <tbody id="transaksi_container">

        </tbody>
    </table>
</div>
@stop
@section('footer') 
    {!! HTML::script('js/cari_transaksi.js')!!}
  <script charset="utf-8">
    refreshTransaksi();
  </script>
@stop
