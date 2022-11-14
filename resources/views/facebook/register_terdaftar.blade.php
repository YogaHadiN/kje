@extends('layout.master')

@section('title') 
{{ ucwords( \Auth::user()->tenant->name ) }} | Register Terdaftar

@stop
@section('page-title') 
<h2>Register Terdaftar</h2>
<ol class="breadcrumb">
	  <li>
		  <a href="{{ url('laporans')}}">Home</a>
	  </li>
	  <li class="active">
		  <strong>Register Terdaftar</strong>
	  </li>
</ol>

@stop
@section('content') 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Register Terdaftar</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<div class="table-responsive">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>Nama Pasien</th>
											<th>{{ $pasien->nama }}</th>
										</tr>
										<tr>
											<th>Alamat</th>
											<th>{{ $pasien->alamat }}</th>
										</tr>
										<tr>
											<th>No Telp</th>
											<th>{{ $pasien->no_telp }}</th>
										</tr>
										<tr>
											<th>Tanggal Lahir</th>
											<th>{{ $pasien->tanggal_lahir }}</th>
										</tr>
									</thead>
									<tbody>
										@if($->count() > 0)
											@foreach($ as $)
												<tr>
													<td>{{ $-> }}</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td class="text-center" colspan="">Tidak Ada Data Untuk Ditampilkan :p</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

							<div class="form-group @if($errors->has('asuransi_id'))has-error @endif">
								{!! Form::label('asuransi_id', 'Pembayaran', ['class' => 'control-label']) !!}
							  {!! Form::select('asuransi_id' , App\Models\Classes\Yoga::asuransiList(), $asuransi_id, ['class' => 'form-control', 'data-live-search' => 'true']) !!}
							  @if($errors->has('asuransi_id'))<code>{{ $errors->first('asuransi_id') }}</code>@endif
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

