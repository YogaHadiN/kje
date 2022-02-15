@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Harian Kasir

@stop
@section('page-title') 

 <h2>Laporan Harian Kasir</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Harian Kasir</strong>
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
        
                        <h3>Laporan Tanggal : {!! App\Models\Classes\Yoga::updateDatePrep($mulai) !!} s/d {!! App\Models\Classes\Yoga::updateDatePrep($akhir) !!}</h3>
                    </div>
                    <div class="panelRight">
                        <h3>Total : {!! $pendapatans->count() !!}</h3>
                    </div>
                </div>
          </div>
          <div class="panel-body responsive">
			  <div class="table-responsive">
					<table class="table table-bordered table-hover" id="tableAsuransi">
					  <thead>
						<tr>
							<th>No</th>
							<th>Pendapatan</th>
							<th>Jumlah</th>
							<th>Yang Menerima</th>
							<th>Yang Menyerahkan Uang</th>
						</tr>
					</thead>
					<tbody>
						@if (count($pendapatans) > 0)
							@foreach ($pendapatans as $key => $pendapatan)
							<tr>
								<td>{!! $key + 1 !!}</td>
								<td>{!! $pendapatan->pendapatan !!}</td>
								<td class='uang'>{!! $pendapatan->biaya !!}</td>
								<td>{!! $pendapatan->staf->nama !!}</td>
								<td>{!! $pendapatan->keterangan !!}</td>
							</tr>
							@endforeach
						@else
							<tr>
								<td colspan="6" class="text-center">Tidak / Belum ada transaksi tanggal {!! App\Models\Classes\Yoga::updateDatePrep($mulai) !!} s/d {!! App\Models\Classes\Yoga::updateDatePrep($akhir) !!}</td>
							</tr>
						@endif
					</tbody>
				</table>
			  </div>
          </div>
    </div>
    </div>
</div>

@stop
@section('footer') 
	
@stop
