@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Harian Admedika

@stop
@section('page-title') 

 <h2>Laporan Harian Admedika</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Harian Admedika</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
          <div class="panel-heading">
                <div class="panel-title">
                    <div class="panelLeft">
                        <h3>Laporan Tanggal : {!! App\Models\Classes\Yoga::updateDatePrep($tanggal) !!} || Asuransi = {!! $asuransi !!}</h3>
                    </div>
                    <div class="panelRight">
                        <h3>Total : {!! count($periksas) !!}</h3>
                    </div>
                </div>
          </div>
          <div class="panel-body responsive">
                <table class="table table-bordered table-hover" id="tableAsuransi">
                      <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pasien</th>
                            @foreach($rincian as $rinci)
                                <th> {!! $rinci->tipe_laporan_admedika !!} </th>
                            @endforeach
                            <th>Dibayar Pasien</th>
                            <th>Dibayar Asuransi</th>
                            <th>Action</th>
                            <th class="hide">periksa_id</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($periksas) > 0)
                            @foreach ($periksas as $key => $periksa)
                            <tr>
                                <td>{!! $key + 1 !!}</td>
                                <td>{!! $periksa->nama_pasien !!}</td>
                                    {!! App\Models\Classes\Yoga::laporanRinci($rincian, $periksa) !!}
                                <td class='uang'>{!! $periksa->tunai !!}</td>
                                <td class='uang'>{!! $periksa->piutang !!}</td>
                                <td><a href="{{ url('periksas/' . $periksa->periksa_id ) }}" class="btn btn-info">details</a></td>
                                <td class="hide">{!! $periksa->id!!}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Tidak / Belum ada transaksi tanggal {!! App\Models\Classes\Yoga::updateDatePrep($tanggal) !!}</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <td colspan="{!! count($rincian) !!}"></td>
                            <td class="uang">{!! App\Models\Classes\Yoga::totalTunaiHarian($periksas)!!}</td>
                            <td class="uang">{!! App\Models\Classes\Yoga::totalPiutangHarian($periksas)!!}</td>
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
