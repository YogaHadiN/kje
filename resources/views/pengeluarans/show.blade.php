@extends('layout.master')

@section('title') 
Klinik Jati Elok | Detil Pengeluaran

@stop
@section('page-title') 
<h2>Detail Pengeluaran</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Detail Pengeluaran</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nomor Faktur : {!! $nota->nomor_faktur !!} | {!! $nota->supplier->nama !!} </h3>
                </div>
                <div class="panelRight">
                	{{-- <h3> Tanggal : {!! App\Classes\Yoga::updateDatePrep($nota->tanggal)!!}</h3> --}}
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover" id="tableEntriBeli">
                  <thead>
                    <tr>
                       <th>No</th>
                       <th>Pengeluaran</th>
                       <th>Harga Satuan</th>
                       <th>Jumlah</th>
                       <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach ($pengeluarans as $key => $pengeluaran)
                     <td> {!! $key + 1!!} </td>
                     <td> {!! $pengeluaran->bukanobat->nama !!} </td>
                     <td class="uang"> {!! $pengeluaran->harga_satuan !!} </td>
                     <td> {!! $pengeluaran->jumlah !!} </td>
                     <td class="uang"> {!! $pengeluaran->jumlah * $pengeluaran->harga_satuan !!} </td>
                	</tr>
                	@endforeach
                </tbody>
                <tfoot>
                    <tr>
                      <td colspan="5" class="text-right bold"> Total Biaya :
                      <span class="bold uang" id="totalHargaObat" colspan="2">{!! $nota->jumlah_pengeluaran !!}</span></td>
                    </tr>
                </tfoot>
            </table>
      </div>
</div>
@stop
@section('footer') 
@stop
