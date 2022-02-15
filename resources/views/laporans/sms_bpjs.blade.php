@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Laporan SMS BPJS

@stop
@section('head') 
<style type="text/css" media="all">
.smskontak tr td:first-child, .smskontak tr th:first-child {
	width:20%
}

.smskontak tr td:nth-child(2), .smskontak tr th:nth-child(2) {
	width:50%
}
.smskontak tr td:nth-child(3), .smskontak tr th:nth-child(3) {
	width:30%
}
</style>
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
					<li role="presentation" class="active"><a href="#sms_kontak" aria-controls="sms_kontak" role="tab" data-toggle="tab">Sms Berhasil ({{ $sms_kontak->count() }})</a></li>
					<li role="presentation"><a href="#sms_gagal" aria-controls="sms_gagal" role="tab" data-toggle="tab">Sms Gagals ({{ $sms_gagal->count() }})</a></li>
					<li role="presentation"><a href="#sms_masuk" aria-controls="sms_masuk" role="tab" data-toggle="tab">Sms Masuk ({{ $sms_masuk->count() }})</a></li>
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
									<table id="table-smskontak"class="table table-hover table-condensed DT smskontak">
										<thead>
											<tr>
												<th>Informasi</th>
												<th>Pesan</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($sms_kontak as $sms)
											<tr @if( $sms->pcare_submit == '2' ) class="danger" @endif >
												<td>
												<strong>Tanggal :</strong><br /> {{ $sms->created_at->format('d-m-Y') }} <br /><br />
												<strong>Nama :</strong><br /> {{ $sms->pasien->nama }} <br />
												<strong>No BPJS :</strong><br />  {{ $sms->pasien->nomor_asuransi_bpjs }} <br />
												<strong>No Telp :</strong><br />  {{ $sms->pasien->no_telp }}
												</td>
												<td>{{ $sms->pesan }}</td>
												<td>
													{!! Form::open(['url' => 'laporans/sms/kontak/action', 'method' => 'post']) !!}
															{!! Form::text('id', $sms->id, ['class' => 'form-control hide']) !!}
															{!! Form::text('nama', $sms->pasien->nama, ['class' => 'hide nama']) !!}
															{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
															{!! Form::select('pcare_submit', $pcare_submits, $sms->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
															{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
														{!! Form::close() !!}
													</td>
												</tr>
											@endforeach
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
								<table class="table table-hover table-condensed DT smskontak">
									<thead>
										<tr>
											<th>Informasi</th>
											<th>Pesan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($sms_gagal as $sms)
											<tr>
												<td>
													<strong>Nama :</strong><br /> {{ $sms->pasien->nama }} <br />
													<strong>No BPJS :</strong><br />  {{ $sms->pasien->nomor_asuransi_bpjs }} <br />
													<strong>No Telp :</strong><br />  {{ $sms->pasien->no_telp }}
												</td>
												<td>
													<strong>Pesan :</strong><br />
													{{ $sms->pesan }}<br /><br />
													<strong>Error :</strong><br />
													{{ $sms->error }}
												</td>
												<td>
													{!! Form::open(['url' => 'laporans/sms/gagal/action', 'method' => 'post']) !!}
														{!! Form::text('id', $sms->pasien_id, ['class' => 'form-control hide']) !!}
														{!! Form::text('nama', $sms->pasien->nama, ['class' => 'hide nama']) !!}
														{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
														{!! Form::select('pcare_submit', $pcare_submits, $sms->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
														{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
													{!! Form::close() !!}
												</td>
											</tr>
										@endforeach
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
								<table class="table table-hover table-condensed DT smskontak">
									<thead>
										<tr>
											<th>Informasi</th>
											<th>Pesan</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($sms_masuk as $sms)
											<tr>
												<td>
													<strong>Nama :</strong><br /> {{ $sms->pasien->nama }} <br />
													<strong>No BPJS :</strong><br />  {{ $sms->pasien->nomor_asuransi_bpjs }} <br />
													<strong>No Telp :</strong><br />  {{ $sms->pasien->no_telp }}
												</td>
												<td>{{ $sms->pesan }}</td>
												<td>
													{!! Form::open(['url' => 'laporans/sms/kontak/action', 'method' => 'post']) !!}
														{!! Form::text('id', $sms->id, ['class' => 'form-control hide']) !!}
														{!! Form::text('nama', $sms->pasien->nama, ['class' => 'hide nama']) !!}
														{!! Form::text('previous', null, ['class' => 'hide previous']) !!}
														{!! Form::select('pcare_submit', $pcare_submits, $sms->pcare_submit, ['class' => 'form-control pcareSubmit']) !!}
														{!! Form::submit('Terdaftar di PCare', ['class' => 'hide submit']) !!}
													{!! Form::close() !!}
												</td>
											</tr>
										@endforeach
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
	
	<script type="text/javascript" charset="utf-8">
		
		$('.pcareSubmit').focus(function(){
			$(this).closest('form').find('.previous').val($(this).val());
		}).change(function(){
			var text = $(this).find('option:selected').text();
			var nama = $(this).closest('form').find('.nama').val();
			var r = confirm('Anda yakin ' + nama + ' ' + text + '?' );
			if(r){
				$(this).closest('form').find('.submit').click();
			} else {
				var previous = $(this).closest('form').find('.previous').val();
				$(this).val(previous);
				$(this).closest('form').find('.previous').val('');
			}
		}).blur(function(){
			$(this).closest('form').find('.previous').val('');
		});

		function dummySubmit(control, nama){
			 var r = confirm('Anda yakin ' + nama + ' sudah diproses di Pcare?');
			 if(r){
				$(control).closest('form').find('.submit').click();
			 }
		}
	</script>
@stop

