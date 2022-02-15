@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan ANC Bulanan
@stop
@section('page-title') 
 <h2>Laporan ANC Bulana</h2>
 <ol class="breadcrumb">
      <li>
          <a href="{!! url('laporans')!!}">Home</a>
      </li>
      <li class="active">
          <strong>Laporan ANC Bulana</strong>
      </li>
</ol>
@stop
@section('content') 
<div class="panel panel-primary">
    <div class="panel-heading">

            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Daftar Laporan ANC Bulana</h3>
                </div>
                <div class="panelRight">
                    <h3>
                        Total : {!! count( $periksas ) !!}
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
						<th>Nama Staf</th>
						<th>Poli</th>
						<th>Pemeriksaan Fisik</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($periksas as $periksa)
						<tr>
							<td>{!! App\Models\Classes\Yoga::updateDatePrep( $periksa->tanggal ) !!}</td>
							<td>{!! $periksa->jam !!}</td>
							<td>{!! $periksa->nama_pasien !!}</td>
							<td>{!! $periksa->nama_staf !!}</td>
							<td>{!! $periksa->poli !!}</td>
							<td>{!! $periksa->pf !!}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
        
    </div>
</div>
<div class="panel panel-danger">
    <div class="panel-heading">

            <div class="panel-title">
                <div class="panelLeft">
                    <h3>Laporan ANC Bulanan</h3>
                </div>
                <div class="panelRight">
                </div>
            </div>
    </div>
    <div class="panel-body">
		<div class="table-responsive">
			<table class="table table-hover table-condensed">
				<thead>
					<tr>
						<th>Nama Staf</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($group_by_stafs as $periksa)
						<tr>
							<td>{!! $periksa->nama_staf !!}</td>
							<td>{!! $periksa->jumlah !!}</td>
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




