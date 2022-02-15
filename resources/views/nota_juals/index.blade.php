@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Penjualan Obat Tanpa Resep

@stop
@section('page-title') 
<h2>Antrian Belanja</h2>
<ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Penjualan Obat Tanpa Resep</strong>
      </li>
</ol>
@stop
@section('content') 
@if (Session::has('print'))
   <div id="print-struk">
       
   </div> 
@endif

<div class="panel panel-primary">
      <div class="panel-heading">
            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Total : {!! $nota_juals->count() !!}</h3>
                </div>
                <div class="panelRight"></div>
                </div>
               
            </div>
      <div class="panel-body">
		  <div class="table-responsive">
				<table class="table table-bordered table-hover DT" id="tabel_faktur_beli">
					  <thead>
						<tr>
						  <th>Nomor Faktur</th>
						  <th>Jenis Penjualan</th>
						  <th>tanggal</th>
						  <th>Nama Staf</th>
						  <th>Jumlah Item</th>
						   <th>Total Biaya</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					  @if($nota_juals->count())
						@foreach ($nota_juals as $nj)
							<tr>
							<td><div>{!!$nj->id !!}</div></td>
							<td><div>{!!$nj->tipeJual->tipe_jual !!}</div></td>
							<td><div>{!!App\Models\Classes\Yoga::updateDatePrep($nj->tanggal)!!}</div></td>
							<td><div>{!!$nj->staf->nama !!}</div></td>
							@if($nj->tipe_jual_id == 1)
								<td><div>{!!$nj->penjualan->count() !!} pcs</div></td>
							@elseif($nj->tipe_jual_id == 2)
								<td><div>{!!$nj->pendapatan->count() !!} pcs</div></td>
							@endif
							<td class="text-right"><div>{!! App\Models\Classes\Yoga::buatrp( $nj->total ) !!}</div></td>
							<td> 
								<a class="btn btn-success btn-xs" href="{{ url('nota_juals/' . $nj->id) }}">Detail</a>
								<a target="_blank" class="btn btn-info btn-xs" href="{{ url('pdfs/penjualan/' . $nj->id) }}">Print Struk</a>
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
<script type="text/javascript" charset="utf-8">
    $(function () {
        if( $('#print-struk').length ){
            window.open("{{ url('pdfs/penjualan/' . Session::get('print')) }}", '_blank');
        }
    });
</script>

@stop

