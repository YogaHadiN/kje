@extends('layout.master')

@section('title') 
Klinik Jati Elok | Entri Beli Obat

@stop
@section('page-title') 
<h2>Pembelian Obat</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('faktur_belis')}}">Antrian Pembelian</a>
      </li>
      <li class="active">
          <strong>Entri</strong>
      </li>
</ol>

@stop
@section('content') 
  
<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nomor Faktur :</h3>
                </div>
                <div class="panelRight bold">
                  <span class="">Total : </span><span class="uang " id="totalHargaObat">0</span>
                </div>

            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered DT" id="tableEntriBeli" nowrap>
                  <thead>
                    <tr>
                       <th>id</th>
                       <th>Nomor Faktur</th>
                       <th>Merek Obat</th>
                       <th>Harga Beli</th>
                       <th>Harga Jual</th>
                       <th>Exp Date</th>
                       <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                	 @foreach($pembelians as $k => $v)
                        <tr>
                          <td>{!! $v->id !!}</td>
                          <td><a href="{{ url('pembelians/show/' . $v->faktur_belanja_id) }}">{!! $v->fakturBelanja->nomor_faktur!!}</a></td>
                          <td>
                            @if($v->merek)
                            {!! $v->merek->merek!!}
                            @else
                            {!!$v->merek_id !!}
                            @endif
                          </td>
                          <td class="uang">{!! $v->harga_beli!!}</td>
                          <td class="uang">{!! $v->harga_jual!!}</td>
                          <td>{!! App\Classes\Yoga::updateDatePrep($v->exp_date)!!}</td>
                          <td>{!! $v->jumlah!!}</td>
                        </tr>
                   @endforeach
                </tbody>
                  
            </table>


      </div>
</div>

@stop