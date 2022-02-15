@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Gigi
@stop
@section('page-title') 
 <h2>Cehckout Kasir (Nota Z)</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Pasien Gigi</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-primary">
    <div class="panel-heading">

            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Laporan Pasien Gigi</h3>
                </div>
                <div class="panelRight">
                    <h3>
                        Total : {!! $periksas->count() !!}
                    </h3>
                </div>
            </div>
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Jam</th>
						<th>Nama Pasien</th>
						<th>Poli</th>
						<th>Pemeriksaan Fisik</th>
						<th>Terapi</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($periksas as $periksa)
						<tr>
							<td>{!! App\Models\Classes\Yoga::updateDatePrep( $periksa->tanggal ) !!}</td>
							<td>{!! $periksa->jam !!}</td>
							<td>{!! $periksa->pasien->nama !!}</td>
							<td>{!! $periksa->poli !!}</td>
							<td>{!! $periksa->pemeriksaan_fisik !!}</td>
							<td>{!! $periksa->terapi_html !!}</td>
						</tr>
					@endforeach
					
				</tbody>
			</table>
		</div>
        
    </div>
</div>

@stop
@section('footer') 
@stop



