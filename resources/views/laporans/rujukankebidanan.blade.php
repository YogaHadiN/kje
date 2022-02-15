@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Rujukan Kebidanan

@stop
@section('page-title') 

 <h2>Laporan Rujukan Kebidanan</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{{ url('laporans')}}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Rujukan Kebidanan</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-info">
              <div class="panel-heading">
                    <div class="panelLeft">
                        <h3>Ringkasan Laporan</h3>
                    </div>
                    <div class="panelRight">
                        <h3>Jumlah :{!! count($rujukans) !!}</h3>
                    </div>
              </div>
              <div class="panel-body">
				  <div class="table-responsive">
						<table class="table table-condensed table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Pasien</th>
									<th>Umur Ibu</th>
									<th>Umur Kehamilan</th>
									<th>G P A</th>
									<th>Diagnosa Merujuk</th>
									<th>Tempat Rujukan</th>
									<th>Tanggal Merujuk</th>
									<th>Alasan Rujuk</th>
								</tr>
							</thead>
							<tbody>
							@if (count($rujukans) > 0)
								@foreach ($rujukans as $key => $rujukan)
									<tr>
										<td>{!! $key + 1 !!}</td>
										<td>{!! $rujukan->nama_pasien !!}</td>
										<td>{!! App\Models\Classes\Yoga::datediff($rujukan->tanggal_lahir, $rujukan->tanggal) !!}</td>
										<td> tidak tau </td>
										<td> tidak tau </td>
										<td>{!! $rujukan->icd10_id!!} - {!! $rujukan->diagnosa !!}</td>
										<td> tidak tau </td>
										<td>{!! App\Models\Classes\Yoga::updateDatePrep($rujukan->tanggal) !!}</td>
										<td>{!! $rujukan->complication !!}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="2" class="text-center">Tidak ada data untuk ditampilkan :p</td>
								</tr>
							@endif

							</tbody>
							<tfoot>
								<th> Jumlah </th>
								<td></td>
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
