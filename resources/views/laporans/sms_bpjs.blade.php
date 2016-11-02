@extends('layout.master')

@section('title') 
Klinik Jati Elok | Laporan SMS BPJS

@stop
@section('page-title') 
<h2>Laporan SMS BPJS</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Laporan SMS BPJS</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="panel panel-default">
		<div class="panel-body">
			<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#sms_kontak" aria-controls="sms_kontak" role="tab" data-toggle="tab">Sms Berhasil</a></li>
				<li role="presentation"><a href="#sms_gagal" aria-controls="sms_gagal" role="tab" data-toggle="tab">Sms Gagal</a></li>
				<li role="presentation"><a href="#sms_masuk" aria-controls="sms_masuk" role="tab" data-toggle="tab">Sms Masuk</a></li>
			  </ul>
			
			  <!-- Tab panes -->
			  <div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="sms_kontak">
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">SMS Berhasil</div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>Nama Pasien</th>
											<th>No Telp</th>
											<th>Pesan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if($sms_kontak->count() > 0)
											@foreach($sms_kontak as $sms)
												<tr>
													<td>{{ $sms->pasien->nama }}</td>
													<td>{{ $sms->pasien->no_telp }}</td>
													<td>{{ $sms->pesan }}</td>
													<td>
														{!! Form::open(['url' => 'laporans/sms/kontak/action', 'method' => 'post']) !!}
															{!! Form::text('id', $p->pasien_id, ['class' => 'form-control hide']) !!}
															{!! Form::text('nama', $p->nama_pengantar, ['class' => 'hide nama']) !!}
															{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
															{!! Form::select('pcare_submit', $pcare_submits, $p->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
															{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
														{!! Form::close() !!}
													</td>
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
					</div>
				</div>
				<div role="tabpanel" class="tab-pane" id="sms_gagal">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<div class="panel-title">SMS Gagal</div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>Nama Pasien</th>
											<th>No Telp</th>
											<th>Error</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if($sms_gagal->count() > 0)
											@foreach($sms_gagal as $sms)
												<tr>
													<td>{{ $sms->pasien->nama }}</td>
													<td>{{ $sms->pasien->no_telp }}</td>
													<td>{{ $sms->error }}</td>
													<td>
														{!! Form::open(['url' => 'laporans/sms/gagal/action', 'method' => 'post']) !!}
															{!! Form::text('id', $p->pasien_id, ['class' => 'form-control hide']) !!}
															{!! Form::text('nama', $p->nama_pengantar, ['class' => 'hide nama']) !!}
															{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
															{!! Form::select('pcare_submit', $pcare_submits, $p->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
															{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
														{!! Form::close() !!}
													</td>
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
					</div>
					
					
				
				</div>
				<div role="tabpanel" class="tab-pane" id="sms_masuk">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<div class="panel-title">SMS Masuk</div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>Nama Pasien</th>
											<th>No Telp</th>
											<th>Pesan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@if($sms_gagal->count() > 0)
											@foreach($sms_gagal as $sms)
												<tr>
													<td>{{ $sms->pasien->nama }}</td>
													<td>{{ $sms->pasien->no_telp }}</td>
													<td>{{ $sms->pesan }}</td>
													<td>
														{!! Form::open(['url' => 'laporans/sms/masuk/action', 'method' => 'post']) !!}
															{!! Form::text('id', $p->pasien_id, ['class' => 'form-control hide']) !!}
															{!! Form::text('nama', $p->nama_pengantar, ['class' => 'hide nama']) !!}
															{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
															{!! Form::select('pcare_submit', $pcare_submits, $p->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
															{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
														{!! Form::close() !!}
													</td>
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
					</div>
					
					
				
				</div>
			  </div>
			
			</div>
			
		</div>
	</div>
	
		
@stop
@section('footer') 
	
@stop

