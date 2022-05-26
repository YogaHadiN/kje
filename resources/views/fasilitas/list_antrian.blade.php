@extends('layout.master')

@section('title') 
Klinik Jati Elok | List Antrian

@stop
@section('page-title') 
<h2>List Antrian</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>List Antrian</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<div class="panelLeft">
					List Antrian
				</div>
				<div id="Antrian Terakhir" class="panelRight">
				</div>
			</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<a href="{{ url('fasilitas/antrian_pasien/tambah/1') }}" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dokter Umum</a>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<a href="{{ url('fasilitas/antrian_pasien/tambah/2') }}" class="btn btn-warning btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dokter Gigi</a>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<a href="{{ url('fasilitas/antrian_pasien/tambah/3') }}" class="btn btn-info btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Bidan</a>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<a href="{{ url('fasilitas/antrian_pasien/tambah/4') }}" class="btn btn-success btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Estetika</a>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<a href="{{ url('fasilitas/antrian_pasien/tambah/7') }}" class="btn btn-success btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Rapid Test</a>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<a href="{{ url('fasilitas/antrian_pasien/tambah/8') }}" class="btn btn-primary btn-lg btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Medical Checkup</a>
				</div>
			</div>
			<br>
			<div class="table-responsive">
				<table class="table table-hover table-condensed table-bordered">
					<thead>
						<tr>
							<th>Id</th>
							<th>Tanggal</th>
							<th>Nomor Antrian</th>
							<th>Jenis Antrian</th>
							<th>Data Antrian</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if($antrians->count() > 0)
							@foreach($antrians as $antrian)
								<tr>
									<td>{{ $antrian->id }}</td>
									<td>{{ $antrian->created_at->format('d M y H:i:s') }}</td>
									<td>{{ $antrian->jenis_antrian->prefix }}{{ $antrian->nomor }}</td>
									<td>{{ $antrian->jenis_antrian->jenis_antrian }}</td>
									<td> @include('fasilitas.data_antrian')</td>
									<td nowrap class="autofit">
										{!! Form::open(['url' => 'antrians/' . $antrian->id, 'method' => 'delete']) !!}
											<a class="btn btn-primary btn-sm" href="{{ url('antrians/proses/' . $antrian->id) }}">
												<span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
											</a>
											<button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus {{ $antrian->nomor_antrian }} ?')" type="submit">
												<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> 
											</button>
											<a target="_blank" class="btn btn-success btn-sm" href="{{ url('pdfs/antrian/' . $antrian->id) }}">
												<i class="fas fa-print"></i>
											</a>
											@include('fasilitas.call_button', ['antrian' => $antrian, 'bigger_button' => true])
										{!! Form::close() !!}
									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5" class="text-center">Tidak ada data untuk ditampilkan</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
@include('panggil')
@section('footer') 
	<script charset="utf-8">
		$('body').tooltip({
			selector: '[rel="tooltip"]'
		});
	</script>
    <script src="{!! asset('js/panggil.js') !!}"></script>
@stop
