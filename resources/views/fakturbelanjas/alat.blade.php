@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Riwayat Belanja Alat

@stop
@section('page-title') 
<h2>Riwayat Belanja Alat</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Riwayat Belanja Alat</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="panel-title">Riwayat Belanja Alat</div>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover DT" id="tabel_faktur_beli">
                  <thead>
                    <tr>
					  <th class='hide'>id</th>
					  <th class='hide'>created_at</th>
                      <th>Tanggal</th>
                      <th>Nama Supplier</th>
                      <th>Nomor Faktur</th>
					  <th>Total Biaya</th>
					  <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if($fakturbelanjas->count())
                  	@foreach ($fakturbelanjas as $faktur_beli)
                		<tr>
                        <td class='hide'><div>{!!$faktur_beli->id!!}</div></td>
                        <td class='hide'><div>{!!$faktur_beli->created_at !!}</div></td>
                        <td><div>{!!App\Models\Classes\Yoga::updateDatePrep($faktur_beli->tanggal)!!}</div></td>
                        <td><div>{!!$faktur_beli->supplier->nama!!}</div></td>
                        <td><div>{!!$faktur_beli->nomor_faktur!!}</div></td>
                        <td><div class="uang">{!!$faktur_beli->totalbiaya!!}</div></td>
                        <td>
							@if($faktur_beli->belanja_id == '4')
                                <a href="{{ url('pengeluarans/peralatans/detail/' . $faktur_beli->id) }}" class="btn-sm btn btn-primary btn-xs">Detail / Edit</a>
                            @endif
                                <a class="btn btn-info btn-xs" href="{{ url('pdfs/pembelian/' . $faktur_beli->id) }}" target="_blank">Print Struk</a>
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
	
@stop
@section('footer') 
	
@stop

