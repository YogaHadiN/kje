@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Entri Beli Obat

@stop
@section('page-title') 
<h2>Riwayat Pembelian</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li>
          <a href="{{ url('pembelians.riwayat')}}">Riwayat</a>
      </li>
      <li class="active">
          <strong>Detail</strong>
      </li>
</ol>

@stop
@section('content') 

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Nomor Faktur : {!! $nota_jual->id !!}<br />Dilakukan Oleh : {!! $nota_jual->staf->nama !!}</h3>
                </div>
                <div class="panelRight">
                    <h3> Tanggal : {!! App\Models\Classes\Yoga::updateDatePrep($nota_jual->tanggal) !!}</h3>
                </div>
            </div>
      </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered" id="tableEntriBeli">
					  <thead>
						<tr>
						   <th>No</th>
						   <th>Merek Obat</th>
						   <th>Harga Jual</th>
						   <th>Jumlah</th>
						   <th>Harga Item</th>
						</tr>
					</thead>
					<tbody>
					
						@foreach ($nota_jual->penjualan as $k => $penj)
							<tr>
								<td>{{ $k + 1 }}</td>
								<td>{{ $penj->merek->merek }}</td>
								<td class="uang">{{ $penj->harga_jual }}</td>
								<td class="text-right">{{ $penj->jumlah }}</td>
								<td class="uang">{{ $penj->harga_jual * $penj->jumlah }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
						  <td colspan="2" class="text-right bold"> Total Biaya : </td>
						  <td class="bold uang" id="totalHargaObat" colspan="3">{!! $nota_jual->nilai !!}</td>
						</tr>
					</tfoot>
				</table>
		  </div>
            <div class="row">
				@if( \Auth::user()->role == '6' )
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<a href="{{ url('nota_juals/' . $nota_jual->id . '/edit') }}" class='btn btn-warning btn-lg btn-block'>Edit</a>            
				</div>
				@endif
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                  <a href="{{ url('penjualans') }}" class='btn btn-danger btn-lg btn-block'>Cancel</a>            
              </div>
            </div>
      </div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Jurnal Umum</h3>
	</div>
	<div class="panel-body">
		@include('jurnal_umums.jurnal_template')
	</div>
</div>
@stop
@section('footer') 
@stop
