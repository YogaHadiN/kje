@extends('layout.master')

@section('title') 
{{ env("NAMA_KLINIK") }} | Verified

@stop
@section('page-title') 
<h2>Verified</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Verified</strong>
	  </li>
</ol>
@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Online</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<tbody>
										<tr>
											<td>Nama Pasien</td>
											<td>{{ $fb->nama_pasien }}</td>
											<td> <button class="btn btn-success btn-xs btn-block" type="button">Pakai Yang Ini</button> </td>
										</tr>
										<tr>
											<td>Alamat</td>
											<td>{{ $fb->alamat_pasien }}</td>
											<td> <button class="btn btn-success btn-xs btn-block" type="button">Pakai Yang Ini</button> </td>
										</tr>
										<tr>
											<td>Tanggal Lahir</td>
											<td>{{ $fb->tanggal_lahir_pasien->format('d-m-Y') }}</td>
											<td> <button class="btn btn-success btn-xs btn-block" type="button">Pakai Yang Ini</button> </td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<tbody>
										<tr>
											<td>No Telp</td>
											<td>{{ $fb->no_hp_pasien }}</td>
											<td> <button class="btn btn-success btn-xs btn-block" type="button">Pakai Yang Ini</button> </td>
										</tr>
										<tr>
											<td>Email</td>
											<td>{{ $fb->email_pasien }}</td>
											<td> <button class="btn btn-success btn-xs btn-block" type="button">Pakai Yang Ini</button> </td>
										</tr>
									</tbody>
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
		{!! Form::model($fb, [
			'url' => 'facebook/verified/'.$fb->id . '/' . $pasien->id, 
			'method' => 'post',
			'files' => 'true'
		]) !!} 
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="panel-title">Isian Pendaftaran</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

							<div class="form-group @if($errors->has('antrian'))has-error @endif">
							  {!! Form::label('antrian', 'Antrian', ['class' => 'control-label']) !!}
							  {!! Form::text('antrian' , $antrian, ['class' => 'form-control angka rq']) !!}
							  @if($errors->has('antrian'))<code>{{ $errors->first('antrian') }}</code>@endif
							</div>
						</div>
						<div class="hide col-xs-4 col-sm-4 col-md-4 col-lg-4">

							<div class="form-group @if($errors->has('poli'))has-error @endif">
							  {!! Form::label('poli', 'Poli', ['class' => 'control-label']) !!}
							  {!! Form::select('poli' , App\Models\Classes\Yoga::poliList(), $fb->pilihan_poli, ['class' => 'form-control rq selectpick', 'data-live-search' => 'true']) !!}
							  @if($errors->has('poli'))<code>{{ $errors->first('poli') }}</code>@endif
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-warning">
				<div class="panel-heading">
					<div class="panel-title">Update Data Pasien</div>
				</div>
				<div class="panel-body">
				@include('pasiens.edit_form', [
					'facebook' => true,
					'pasien' => $fb
				])	
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
@stop
@section('footer') 
	<script type="text/javascript" charset="utf-8">
		var base = '{{ url("/") }}';
	</script>
	{!! HTML::script('js/togglepanel.js')!!}
	<script type="text/javascript" charset="utf-8">
		function dummySubmit(){
			console.log('okeee');
			if(validatePass()){
				$('#submit').click();
			}
		}
	</script>
	
@stop
	
