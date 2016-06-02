@extends('layout.master')

@section('title') 
Klinik Jati Elok | Checkout Kasir
@stop
@section('page-title') 
 <h2>Cehckout Kasir (Nota Z)</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Cehckout Kasir (Nota Z)</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Panel Oke</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-condensed">
                        <thead>
                            <tr>
                                <th>Asuransi</th> 
                                @foreach ($transaksis as $transaksi)
                                <th>{{ $transaksi->jenisTarif->jenis_tarif }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asuransis as $asur)
                            <tr>
                                <td>{{ $asur->asuransi->nama }}</td> 
                                @foreach ($transaksis as $trx)
                                <td>{!! 
                                    App\Classes\Yoga::hitungTindakan($asur->asuransi_id, $trx->jenis_tarif_id, $tanggal)
                                    !!}</td>        
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

  <div class="row">
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <div class="panel panel-success">
              <div class="panel-heading">
                  <div class="panel-title">Informasi Kasir</div>
              </div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-hover table-condensed">
                          <thead>
                              <tr>
                                  <td>Modal Awal</td>
                                  <td class="uang">{{ $modal_awal }}</td>
                              </tr>
                              <tr>
                                  <td>Uang di Kasir</td>
                                  <td class="uang">{{ $uang_di_kasir }}</td>
                              </tr>
                              <tr>
                                  <td>Uang Masuk</td>
                                  <td class="uang">{{ $total_uang_masuk }}</td>
                              </tr>
                              <tr>
                                  <td>Uang Keluar</td>
                                  <td class="uang">{{ $total_uang_keluar }}</td>
                              </tr>
                          </thead>
                      </table>

                  </div>
              </div>
          </div>
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
          <button class="btn btn-primary btn-lg btn-block" type="button"> Checkout </button>
          <button class="btn btn-danger btn-lg btn-block" type="button"> Cancel </button>
      </div>
    
  </div>
   
    
    
@stop
@section('footer') 
@stop


