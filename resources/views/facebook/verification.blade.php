@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Verifikasi Pendaftaran Online

@stop
@section('page-title') 
<h2>Verifikasi Pendaftaran Online</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Verifikasi Pendaftaran Online</strong>
	  </li>
</ol>

@stop
@section('head')
<style type="text/css" media="all">
th{
	text-align : left;
}
</style>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="panel-title">
						<div class="panelLeft">
							
						</div>
						<div class="panelRight">
							
						<a class="btn btn-success btn-lg" href="{{ url('facebook/input_pasien_baru/' . $fb->id) }}">Bila pasien benar adalah pasien baru, maka Klik Disini</a>
						</div>
					
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<tr class="hide">
										<th>Id Facebook Daftar</th>
										<td id="facebook_id">{{ $fb->id }}</td>
									</tr>
									<tr>
										<th>Nama Pasien</th>
										<td>{{ $fb->nama_pasien }}</td>
									</tr>
									<tr>
										<th>Tanggal Lahir</th>
										<td>{{ $fb->tanggal_lahir_pasien->format('d-m-Y') }}</td>
									</tr>
									<tr>
										<th>Alamat</th>
										<td>{{ $fb->alamat_pasien }}</td>
									</tr>
									<tr>
										<th>No HP</th>
										<td>{{ $fb->no_hp_pasien }}</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<tr class="hide">
										<th>Email</th>
										<td>{{ $fb->facebook_id }}</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>{{ $fb->email_pasien }}</td>
									</tr>
									<tr>
										<th>Pilihan Pembayaran</th>
										<td>{{ $fb->pembayaran }}</td>
									</tr>
									<tr>
										<th>Pernah Berobat</th>
										<td>{{ $fb->status_berobat }}</td>
									</tr>
									<tr>
										<th>Created At</th>
										<td>{{ $fb->created_at->format('d-m-Y H:i:s') }}</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-primary">
				  <div class="panel-heading">
						<div class="panel-title">
							<div class="panelLeft">
								<h3>Total : </h3>
							</div>
							<div class="panelRight">
							<a href="#" type="button" class="btn btn-info" data-toggle="modal" data-target="#kriteria"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Parameter Pencarian</a>
							<a href="#" type="button" class="btn btn-success" data-toggle="modal" data-target="#pasienInsert"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> PASIEN Baru</a>
							</div>
						</div>
				  </div>
				  <div class="panel-body">
					  <div class="table-responsive">
							<table class="table table-bordered table-hover" id="tablePasien">
							  <thead>
								<tr>
								{!! Form::open(['url' => 'pasiens/ajax/ajaxpasiens', 'method' => 'get', 'id' => 'ajaxkeyup', 'autocomplete' => 'off'])!!}

									<th class="displayNone">
									   No Status<br>
									   {!! Form::text('id', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'id'])!!}
									</th>
									<th>
										Nama Pasien <br>
									   {!! Form::text('nama', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama'])!!}
									</th>
									<th>
										Alamat <br>
									   {!! Form::text('alamat', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'alamat'])!!}
									</th>
									<th>
										Tanggal Lahir <br>
									   {!! Form::text('tanggal_lahir', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'tanggal_lahir'])!!}
									</th>
									<th>
										No Telp <br>
									   {!! Form::text('no_telp', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'no_telp'])!!}
									</th>
									<th class="displayNone">
										Nama Asuransi <br>
									   {!! Form::text('nama_asuransi', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_asuransi'])!!}
									</th>
									<th class="displayNone">
										No Asuransi <br>
									   {!! Form::text('nomor_asuransi', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nomor_asuransi'])!!}
									</th>
									<th class="displayNone">
										Nama Peserta <br>
									   {!! Form::text('nama_peserta', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_peserta'])!!}
									</th>
									<th class="displayNone">
										Nama Ibu <br>
									   {!! Form::text('nama_ibu', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_ibu'])!!}
									</th>
									<th class="displayNone">
										Nama Ayah <br>
									   {!! Form::text('nama_ayah', null, ['class' => 'form-control-inline form-control ajaxselectpasien', 'id' => 'nama_ayah_Input'])!!}
									</th>
									<th class="displayNone">Asuransi ID</th>
									<th>Action <br> <button class="btn btn-danger  btn-block" id="clear">clear</button></th>

								{!! Form::close()!!}
								</tr>
							</thead>
							<tbody id="ajax">
							  
							</tbody>
						</table>
					  </div>
				  </div>
			</div>
		</div>
		
	</div>
	
@stop
@section('footer') 
	
<script>
  var base = "{{ url('/') }}";
</script>
{!! HTML::script('js/togglepanel.js')!!}
{!! HTML::script('js/verifikasi.js')!!}
@stop

