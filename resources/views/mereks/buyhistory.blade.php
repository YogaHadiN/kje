@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Riwayat Pembelian

@stop
@section('page-title') 
<h2>Riwayat Pembelian</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('mereks')}}">Merek</a>
      </li>
      <li class="active">
          <strong>Riwayat pembelian {!! $pembelians->first()->merek->merek !!}</strong>
      </li>
</ol>

@stop
@section('content') 
  
<div class="panel panel-info">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Supplier yang menyediakan obat {!! $pembelians->first()->merek->merek !!}</h3>
                </div>
                <div class="panelRight bold">

                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
					<table class="table table-bordered table-hover" id="tableEntriBeli" nowrap>
					  <thead>
						<tr>
						   <th>No</th>
						   <th>Nama Apotek</th>
						   <th>Alamat</th>
						   <th>Telepon</th>
						   <th>PIC</th>
						   <th>Harga Beli</th>
						   <th>Harga Tanggal</th>
						</tr>
					</thead>
					<tbody>
					   @foreach($supplierprices as $k => $v)
							<tr>
							  <td>{!! $k +1 !!}</td>
							  <td>{!! $v->nama !!}</td>
							  <td>{!! $v->alamat !!}</td>
							  <td>{!! $v->telepon !!} / {!! $v->hp !!}</td>
							  <td>{!! $v->pic !!}</td>
							  <td>{!! $v->harga_beli!!}</td>
							  <td>{!! $v->tanggal !!}</td>
							</tr>
					   @endforeach
					</tbody>
					  
				</table>
		  </div>


      </div>
</div>

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Semua Riwayat Pembelian</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover" id="tableEntriBeli" nowrap>
					  <thead>
						<tr>
						   <th>No</th>
						   <th>Supplier</th>
						   <th>Nomor Faktur</th>
						   <th>Harga Beli</th>
						   <th>Harga Jual</th>
						   <th>Exp Date</th>
						   <th>Jumlah</th>
						   <th>Lihat</th>
						</tr>
					</thead>
					<tbody>
					   @foreach($pembelians as $k => $v)
							<tr>
							  <td>{!! $k +1 !!}</td>
							  <td>{!! $v->fakturBelanja->supplier->nama !!}</td>
							  <td>{!! $v->fakturBelanja->nomor_faktur !!}</td>
							  <td>{!! $v->harga_beli!!}</td>
							  <td>{!! $v->harga_jual!!}</td>
							  <td>{!! $v->exp_date!!}</td>
							  <td>{!! $v->jumlah!!}</td>
							  <td>
								<div><a href="{{ url('pembelians/show/' . $v->faktur_belanja_id) }}" class="btn-sm btn btn-primary btn-xs">Detail</a></div>
							  </td>

							</tr>
					   @endforeach
					</tbody>
					  
				</table>
		  </div>


      </div>
</div>

@stop
