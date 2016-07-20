@extends('layout.master')

@section('title') 
Klinik Jati Elok | Supplier
@stop
@section('page-title') 
 <h2>Supplier</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('suppliers')}}">Home</a>
      </li>
      <li class="active">
          <strong>Show</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-info">
      <!-- Default panel contents -->
      <div class="panel-heading">Informasi Supplier</div>
        <div class="panel-body">
              <table class="table table-condensed table-hover">
          <tbody>
            <tr>
              <td class="text-bold">Nama</td>
              <td>{!!$supplier->nama!!}</td>
            </tr>
            <tr>
              <td class="text-bold">Alamat</td>
              <td>{!!$supplier->alamat!!}</td>
            </tr>
            <tr>
              <td class="text-bold">No Telp</td>
              <td>{!!$supplier->no_telp!!}</td>
            </tr>
            <tr>
              <td class="text-bold">PC </td>
              <td>{!!$supplier->pic!!}</td>
            </tr>
            <tr>
              <td class="text-bold">HP PIC</td>
              <td>{!!$supplier->hp_pic!!}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
					Riwayat Pembelian
                </div>
                <div class="panelRight">
                </div>
            </div>
      </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                      <th>tanggal</th>
                      <th>Nomor Faktur</th>
                      <th>Jenis Belanja</th>
                      <th>Jumlah Item</th>
                      <th>Total Biaya</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if($fakturbelanjas->count())
                    @foreach ($fakturbelanjas as $faktur_beli)
                    <tr>
                        <td><div>{!!App\Classes\Yoga::updateDatePrep($faktur_beli->tanggal)!!}</div></td>
                        <td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
                        <td><div>{!!$faktur_beli->belanja->belanja!!}</div></td>
                        <td><div>{!!$faktur_beli->items!!} pcs</div></td>
                        <td><div class="uang">{!!$faktur_beli->totalbiaya!!}</div></td>
                        <td>
                          <a href="{{ url('pembelians/show/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a>
                        </td>
                    </tr>
                    @endforeach
                  @else 
                    <td colspan="6" class="text-center">Tidak Ada Data Untuk Ditampilkan :p</td>
                  @endif
                </tbody>
            </table>
      </div>
</div>
  </div>
</div>

@stop
@section('footer') 


@stop
