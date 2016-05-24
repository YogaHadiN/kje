@extends('layout.master')

@section('title') 
Klinik Jati Elok | Antrian Beli Obat

@stop
@section('page-title') 
<h2>Antrian Belanja</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Cari Faktur Belanja Obat</strong>
      </li>
</ol>
@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $fakturbelanjas->count() !!}</h3>
                </div>
                <div class="panelRight">
                      <a href="{{ url('fakturbelanjas') }}" class='btn btn-info'>List Belum Selesai</a>
                      <a href="{{ url('suppliers') }}" class="btn btn-success">Pilih Supplier Lagi</a>
                  </div>
                </div>
               
            </div>
      <div class="panel-body">
            <table class="table table-bordered table-hover DT" id="tabel_faktur_beli">
                  <thead>
                    <tr>
          						<th>tanggal</th>
                      <th>Nama Supplier</th>
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
                        <td><div>{!!$faktur_beli->supplier->nama!!}</div></td>
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
@stop
@section('footer') 


@stop
