@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan Tanpa Asisten
@stop
@section('page-title') 
 <h2>Laporan Tanpa Asisten</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan Tanpa Asisten</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-primary">
    <div class="panel-heading">

            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Daftar Tidak Ada Asisten Dokter</h3>
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
			<table class="table table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Jam</th>
						<th>Nama Pasien</th>
						<th>Nama Staf</th>
						<th>Poli</th>
						<th>Anamnesis</th>
						<th>Pemeriksaan Fisik</th>
		
				</thead>
				<tbody>
					@foreach ($periksas as $periksa)
						<tr>
							<td>{!! $periksa->tanggal->format('d-m-Y') !!}</td>
							<td>{!! $periksa->jam !!}</td>
							<td>{!! $periksa->pasien->nama !!}</td>
							<td>{!! $periksa->staf->nama !!}</td>
							<td>{!! $periksa->poli !!}</td>
							<td>{!! $periksa->anamnesa !!}</td>
							<td>{!! $periksa->pemeriksaan_fisik !!}</td>
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



