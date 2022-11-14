@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Harian Per Asuransi

@stop
@section('head')
@stop
@section('page-title') 

 <h2>Laporan Harian Per Asuransi</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Harian Per Asuransi</strong>
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
                        <h3>Laporan Tanggal : {!! data('d-m-Y') !!}</h3>
						<h3>{{ $periksa->first()->nama_asuransi }}</h3>
                    </div>
                    <div class="panelRight">
                        <h3>Total : {!! count($periksas) !!}</h3>
                    </div>
                </div>
          </div>
          <div class="panel-body">
			  <div class="table-responsive">
						<table class="table table-bordered table-hover" id="tableAsuransi">
						  <thead>
							<tr>
								<th class="hide">ID PERIKSA</th>
								<th>No</th>
								<th>Nama Pasien</th>
								<th>Pembayaran</th>
								<th>Poli</th>
								<th>Tunai</th>
								<th>Piutang</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if (count($periksas) > 0)
								@foreach ($periksas as $key => $periksa)
								<tr>
									<td class="hide periksa_id">{!! $periksa->periksa_id !!}</td>
									<td>{!! $key + 1 !!}</td>
									<td>{!! $periksa->nama_pasien !!}</td>
									<td>{!! $periksa->nama_asuransi !!}</td>
                                    <td>{!! $periksa->poli->poli !!}</td>
									<td class='uang'>{!! $periksa->tunai !!}</td>
									<td class='uang'>{!! $periksa->piutang !!}</td>
									<td>
										<a href="{{ url('pdfs/kuitansi/' . $periksa->periksa_id ) }}" target="_blank">Kuitansi</a> | 
										<a href="{{ url('pdfs/status/' . $periksa->periksa_id ) }}" target="_blank">Resep</a> | 
										<a href="{{ url('periksas/' . $periksa->periksa_id ) }}" target="_blank">Detail</a> | 
										<a href="{{ url('pdfs/struk/' . $periksa->periksa_id ) }}" target="_blank">Struk</a>  
									</td>
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
								<th colspan="4">Total</th>
								<td class="uang">{!! App\Models\Classes\Yoga::totalTunaiHarian($periksas)!!}</td>
								<td class="uang">{!! App\Models\Classes\Yoga::totalPiutangHarian($periksas)!!}</td>
							</tr>
						</tfoot>
					</table>
			  </div>
          </div>
    </div>
</div>
</div>
@stop
@section('footer') 
	
<script type="text/javascript" charset="utf-8">
    function printStruk(control){
        alert( $(control).closest('tr').find('.periksa_id').html() );
    }
    
</script>
@stop
