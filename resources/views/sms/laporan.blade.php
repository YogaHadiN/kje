@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan SMS Angka Kontak

@stop
@section('page-title') 
<h2>Laporan SMS Angka Kontak</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan SMS Angka Kontak</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-success">
		<div class="panel-heading">
			<div class="panel-title">Laporan SMS Angka Kontak</div>
		</div>
		<div class="panel-body">
			<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#berhasil" aria-controls="berhasil" role="tab" data-toggle="tab">SMS Berhasil</a></li>
				<li role="presentation"><a href="#gagal" aria-controls="gagal" role="tab" data-toggle="tab">SMS Gagal</a></li>
			  </ul>
			  <!-- Tab panes -->
			  <div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="berhasil">
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Nama Pasien</th>
									<th>No Telp</th>
									<th>Pesan</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@if($sms_kontak->count() > 0)
									@foreach($sms_kontak as $sms)
										<tr>
											<td>{{ $sms->pasien->nama }}</td>
											<td>{{ $sms->pasien->no_telp }}</td>
											<td>{{ $sms->pesan }}</td>
											<td>{{ $sms->pcare_submit }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="4">Tidak Ada Data Untuk Ditampilkan :p</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="gagal">
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>Nama Pasien</th>
									<th>No Hp</th>
									<th>Pesan</th>
									<th>Error</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@if($sms_gagal->count() > 0)
									@foreach($sms_gagal as $sms)
										<tr>
											<td>{{ $sms->pasien->nama }}</td>
											<td>{{ $sms->pasien->no_telp }}</td>
											<td>{{ $sms->pesan }}</td>
											<td>{{ $sms->error }}</td>
											<td>{{ $sms->pcare_submit }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td class="text-center" colspan="5">Tidak Ada Data Untuk Ditampilkan :p</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
@stop
@section('footer') 
	
@stop

