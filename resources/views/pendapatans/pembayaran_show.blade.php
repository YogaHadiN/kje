@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Pembayaran

@stop
@section('page-title') 
<h2>Laporan Pembayaran Asuransi {!! $pembayarans->first()->periksa->asuransi->nama !!}</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Per Pembayaran</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">Detail Pembayaran</div>
    </div>
    <div class="panel-body">
        <div class-"table-responsive">
            <table class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>ID PERIKSA</th>
                        <th>Nama Pasien</th>
                        <th>Tunai</th>
                        <th>Piutang</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayarans as $pemb)
                    <tr>
                        <td>{{  $pemb->periksa_id  }}</td>
                        <td>{{  $pemb->periksa->pasien->nama  }}</td>
                        <td class="uang">{{  $pemb->periksa->tunai }}</td>
                        <td class="uang">{{  $pemb->periksa->piutang  }}</td>
                        <td class="uang">{{  $pemb->pembayaran }}</td>
                        <td>
                            @if ($pemb->periksa->piutang - $pemb->pembayaran < 1)
                                <div class="text-center alert-alert success">
                                    Lunas
                                </div>
                            @else
                                <div class="text-center alert-danger">
                                    Belum Lunas
                                </div>

                            @endif
                             
                        </td>
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

