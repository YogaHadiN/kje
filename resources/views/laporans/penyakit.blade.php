@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Laporan Per Tanggal

@stop
@section('page-title') 

 <h2>Laporan Per Tanggal</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Per Tanggal</strong>
      </li>
</ol>

@stop
@section('content') 
<div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h3 class="panel-title">
                              <div class="panelLeft">
                                Periode  {{ App\Models\Classes\Yoga::updateDatePrep( $mulai ) }} s/d {{ App\Models\Classes\Yoga::updateDatePrep( $akhir ) }}
                              </div>
                          </h3>
                      </div>
                      <div class="panel-body">
						  <div class="table-responsive">
								<table class="table table-bordered table-hover DT" id="tableAsuransi">
									  <thead>
										<tr>
											<th>No</th>
											<th>Nama Penyakit ICD</th>
											<th>Jumlah</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if (count($tanggal) > 0)
											@foreach ($tanggal as $key => $tgl)
											<tr>
												<td>{!! $key +1 !!}</td>
												<td>{!! $tgl->id !!} - {!! $tgl->diagnosaICD!!}</td>
												<td>{!! $tgl->jumlah !!}</td>
												<td><a href="#" class="btn btn-primary btn-xs">detail</a></td>
											</tr>
											@endforeach
										@else
											<tr>
												<td colspan="6" class="text-center">Tidak / Belum ada transaksi</td>
											</tr>
										@endif
									</tbody>
									<tfoot>
										<tr>
										  <th colspan="2">Total</th>
										  <td>{!! App\Models\Classes\Yoga::totalPenyakit($tanggal)!!}</td>
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
	
@stop
