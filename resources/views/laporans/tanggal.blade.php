@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan Per Tanggal

@stop
@section('page-title') 
 <h2>Laporan Per Tanggal</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Per Tanggal</strong>
      </li>
</ol>

@stop

@section('content') 
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                            <h3 class="panel-title">Pembarayan : {{ $nama_asuransi }}</h3>
                      </div>
                      <div class="panel-body">
                            <table class="table table-bordered table-hover" id="tableAsuransi">
                                  <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jumlah</th>
                                        <th>Tunai</th>
                                        <th>Piutang</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($tanggal) > 0)
                                        @foreach ($tanggal as $key => $tgl)
                                        <tr>
                                            <td>{!! App\Classes\Yoga::updateDatePrep($tgl->tanggal) !!}</td>
                                            <td>{!! $tgl->jumlah !!}</td>
                                            <td class="uang">{!! $tgl->tunai !!}</td>
                                            <td class="uang">{!! $tgl->piutang !!}</td>
                                            <td><a href="#" class="btn btn-primary btn-xs">detail</a></td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak / Belum ada transaksi</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>Total</th>
                                      <td>{{$totalJumlahTanggal}}</td>
                                      <td class="uang">{{$totalTunaiTanggal}}</td>
                                      <td class="uang">{{$totalPiutangTanggal}}</td>
                                  </tr>
                                </tfoot>
                            </table>
                      </div>
                </div>
          </div>
      </div>
@stop
@section('footer') 
	
@stop
